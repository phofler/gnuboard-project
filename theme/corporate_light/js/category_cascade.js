/**
 * Cascading Category System
 * Independent Module for Theme Corporate Light
 */
function initCascadingCategory(config) {
    var defaults = {
        selector: "#ca_name",           // The original hidden input/select
        codeStorage: "#wr_1",           // Where to store the leaf code
        wrapper: "#category_container", // Wrapper for dynamic selects
        bo_table: "",                   // Board ID
        ajaxUrl: "",                    // Endpoint URL
        initialCaName: "",              // Initial Value (Name path)
        initialCode: "",                // Initial Value (Code)
        validCategories: []             // Array of valid strings "A > B"
    };
    var cfg = $.extend({}, defaults, config);

    var $originalSelect = $(cfg.selector);
    var $codeStorage = $(cfg.codeStorage);
    var $wrap = $(cfg.wrapper);

    // Validate
    if (!cfg.ajaxUrl || !cfg.bo_table) {
        console.error("Cascading Category: ajaxUrl and bo_table are required.");
        $originalSelect.show();
        return;
    }

    // Fetch Tree Data
    $.ajax({
        url: cfg.ajaxUrl,
        data: { bo_table: cfg.bo_table },
        dataType: "json",
        success: function (res) {
            if (!res.success || !res.data || res.data.length === 0) {
                // Fallback: Show original if no tree data
                $originalSelect.show();
                return;
            }

            // Process Data into Tree Structure
            var treeData = buildTree(res.data);
            var hiddenRootName = "";

            // SEARCH FOR ROOT UNWRAPPING
            // If the tree has only 1 top-level node (e.g., "시공사례"), and it has children,
            // we probably want to start selection from the children (e.g., "RESIDENCE").
            if (treeData.length === 1 && treeData[0].children && treeData[0].children.length > 0) {
                hiddenRootName = treeData[0].name;
                treeData = treeData[0].children;
            }

            renderCascadingSelects(treeData, $wrap, $originalSelect, $codeStorage, cfg.initialCaName, cfg.initialCode, cfg.validCategories, hiddenRootName);
        },
        error: function (err) {
            console.error("Cascading Category: AJAX Failed", err);
            $originalSelect.show();
        }
    });

    /**
     * Converts flat list to tree
     */
    function buildTree(flatData) {
        var map = {};
        var tree = [];
        flatData.forEach(function (node) {
            map[node.code] = { ...node, children: [] };
        });
        flatData.forEach(function (node) {
            if (node.parent && node.parent !== 'root' && map[node.parent]) {
                map[node.parent].children.push(map[node.code]);
            } else {
                tree.push(map[node.code]);
            }
        });
        return tree;
    }

    /**
     * Renders Select Boxes
     */
    function renderCascadingSelects(treeData, $container, $originalSelect, $codeStorage, initialCaName, initialCode, validCategories, hiddenRootName) {
        // Initialize Selects
        var $depth1 = $("<select class='product-category-select dynamic-cate form-select'><option value=''>대분류 선택</option></select>");
        var $depth2 = $("<select class='product-category-select dynamic-cate form-select' style='display:none;'><option value=''>중분류 선택</option></select>");
        var $depth3 = $("<select class='product-category-select dynamic-cate form-select' style='display:none;'><option value=''>소분류 선택</option></select>");

        // Apply CSS class from config if needed, but 'form-select' should handle it via theme
        // Added 'form-select' class for Magazine skin compatibility

        $container.empty().append($depth1, $depth2, $depth3);

        // Populate Depth 1
        treeData.forEach(function (node) {
            $depth1.append(new Option(node.name, node.code));
        });

        // Helper: Find Node
        function findNode(nodes, code) {
            for (var i = 0; i < nodes.length; i++) {
                if (nodes[i].code == code) return nodes[i];
                if (nodes[i].children) {
                    var found = findNode(nodes[i].children, code);
                    if (found) return found;
                }
            }
            return null;
        }

        // Event: Depth 1 Change
        $depth1.on("change", function () {
            var val = $(this).val();
            $depth2.empty().append(new Option("중분류 선택", "")).hide();
            $depth3.empty().append(new Option("소분류 선택", "")).hide();

            if (val) {
                var node = findNode(treeData, val);
                if (node && node.children.length > 0) {
                    node.children.forEach(function (child) {
                        $depth2.append(new Option(child.name, child.code));
                    });
                    $depth2.show();
                }
            }
            updateFinalValues();
        });

        // Event: Depth 2 Change
        $depth2.on("change", function () {
            var val = $(this).val();
            $depth3.empty().append(new Option("소분류 선택", "")).hide();

            if (val) {
                var parentVal = $depth1.val();
                var parentNode = findNode(treeData, parentVal);
                if (parentNode) {
                    var node = findNode(parentNode.children, val);
                    if (node && node.children.length > 0) {
                        node.children.forEach(function (child) {
                            $depth3.append(new Option(child.name, child.code));
                        });
                        $depth3.show();
                    }
                }
            }
            updateFinalValues();
        });

        // Event: Depth 3 Change
        $depth3.on("change", function () {
            updateFinalValues();
        });

        /**
         * Update Hidden Inputs (Core Logic)
         */
        function updateFinalValues() {
            var d1 = $depth1.val();
            var d2 = $depth2.val();
            var d3 = $depth3.val();

            var lastCode = d3 || d2 || d1;
            $codeStorage.val(lastCode);

            // Construct Name Path
            var parts = [];
            if (d1) parts.push($depth1.find("option:selected").text());
            if (d2) parts.push($depth2.find("option:selected").text());
            if (d3) parts.push($depth3.find("option:selected").text());

            var pathSpace = parts.join(" > ");
            var pathNoSpace = parts.join(">");
            var finalVal = pathSpace;

            // Validate against validCategories (Server consistency check)
            if (validCategories && validCategories.length > 0) {
                function check(p) { return validCategories.indexOf(p) !== -1; }

                if (check(pathSpace)) { finalVal = pathSpace; }
                else if (check(pathNoSpace)) { finalVal = pathNoSpace; }
                else if (hiddenRootName) {
                    var withRoot = hiddenRootName + " > " + pathSpace;
                    if (check(withRoot)) { finalVal = withRoot; }
                }

                // Fuzzy/Suffix Match
                if (finalVal === pathSpace && !check(finalVal)) {
                    var suffixSpace = " > " + pathSpace;
                    for (var i = 0; i < validCategories.length; i++) {
                        var vc = validCategories[i];
                        if (vc.endsWith(suffixSpace) || vc === pathSpace) { // endsWith polyfill might be needed?
                            finalVal = vc; break;
                        }
                    }
                }
            }

            $originalSelect.val(finalVal);
        }

        // --- Initial Load Logic ---
        var urlParams = new URLSearchParams(window.location.search);
        var targetCode = initialCode;
        var targetCaName = initialCaName || urlParams.get('ca_name');

        if (targetCode) {
            selectByCode(targetCode);
        }

        // Fallback: Select by Name if Code failed
        if (!$depth1.val() && targetCaName) {
            selectByNamePath(targetCaName);
        }

        function selectByCode(code) {
            var seg1 = code.substring(0, 2);
            if (seg1.length === 2 && $depth1.find("option[value='" + seg1 + "']").length) {
                $depth1.val(seg1).trigger("change");
                if (code.length >= 4) {
                    var seg2 = code.substring(0, 4);
                    $depth2.val(seg2).trigger("change");
                    if (code.length >= 6) {
                        var seg3 = code.substring(0, 6);
                        $depth3.val(seg3).trigger("change");
                    }
                }
            }
        }

        function selectByNamePath(path) {
            var parts = path.split(">").map(function (s) { return s.trim(); });
            // Remove hidden root if it appears in path but not in dropdowns
            if (hiddenRootName && parts[0] === hiddenRootName) {
                parts.shift();
            }

            if (parts.length > 0) {
                var d1Option = $depth1.find("option").filter(function () { return $(this).text() === parts[0]; });
                if (d1Option.length) {
                    $depth1.val(d1Option.val()).trigger("change");
                    if (parts.length > 1) {
                        var d2Option = $depth2.find("option").filter(function () { return $(this).text() === parts[1]; });
                        if (d2Option.length) {
                            $depth2.val(d2Option.val()).trigger("change");
                            if (parts.length > 2) {
                                var d3Option = $depth3.find("option").filter(function () { return $(this).text() === parts[2]; });
                                if (d3Option.length) {
                                    $depth3.val(d3Option.val()).trigger("change");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
