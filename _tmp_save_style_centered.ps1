$file = 'C:\gnuboard\plugin\top_menu_manager\skins\centered\style.css'
$content = @'
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&family=Noto+Sans+KR:wght@400;700;900&display=swap");

/* Centered Skin Modernized Styles */
.header.centered, .header.centered *, .dep2Wrap, .dep2Wrap *, .gnb, .gnb * { 
    font-family: "Inter", "Noto Sans KR", sans-serif !important; 
}

/* Header Base */
header.centered {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    transition: 0.4s;
}

.gnbWrapBg { 
    background: #fff; 
    border-bottom: 1px solid #e9e9e9; 
    height: auto !important; /* Allow Logo + Nav stack */
    padding: 15px 0;
    transition: 0.3s;
}

/* [Breakout Fix] Force all ancestors between header and dropdown to be static */
#mainHeader .gnbWrapBg,
#mainHeader .gnbArea,
#mainHeader nav,
#mainHeader ul.gnb,
#mainHeader ul.gnb > li {
    position: static !important;
    width: auto;
    max-width: none;
}

#mainHeader .container.gnbArea {
    position: static !important;
    display: flex;
    flex-direction: column; /* Stack Logo and Nav */
    align-items: center;
    justify-content: center;
    height: auto;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    gap: 15px;
}

/* Centered Logo Adjustment */
.logoCentered {
    flex-shrink: 0;
    margin: 0 auto;
}
.logoCentered img {
    height: 33px;
    width: auto;
}

/* GNB Centered Alignment */
.gnb {
    display: flex;
    justify-content: center;
    gap: 0;
    height: auto;
    margin: 0 auto;
}

.gnb>li {
    width: auto;
    padding: 0 25px;
    text-align: center;
}

.gnb>li>a {
    display: block;
    line-height: 40px; /* Reduced for stacked layout */
    font-size: 18px;
    font-weight: 700;
    color: #333;
    transition: 0.3s;
    white-space: nowrap;
}

.gnb>li:hover>a,
.gnb>li.on>a {
    color: var(--edge-color, #c92127) !important;
}

/* Mega Menu Breakout */
.dep2Wrap {
    display: none;
    position: absolute;
    left: 0 !important;
    right: 0 !important;
    top: 100%; /* Align to bottom of header */
    width: 100vw !important;
    margin-left: calc(-50vw + 50%);
    background: #ffffff !important;
    border-top: 1px solid #e9e9e9;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 50px 0;
    z-index: 999;
}

.gnb>li:hover .dep2Wrap {
    display: block;
}

.dep2Wrap2 {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 30px;
    display: flex;
}

.dep2Img {
    width: 28%;
    border-right: 1px solid #e9e9e9;
    padding-right: 30px;
    position: relative;
    overflow: hidden;
}

.menu-icon-bg {
    position: absolute;
    right: -20px;
    bottom: -20px;
    font-size: 100px;
    color: var(--primary-dark, #1a2c5e);
    opacity: 0.06;
    transform: rotate(-15deg);
    pointer-events: none;
}

.dep2Img h2 {
    font-size: 2.2rem;
    color: var(--primary-dark, #1a2c5e);
    font-weight: 800;
    margin-bottom: 15px;
}

.dep2Img .txt {
    font-size: 1rem;
    color: #666;
    line-height: 1.5;
}

.dep2 {
    flex: 1;
    padding-left: 50px;
}

.dep2 > ul {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.dep2 > ul > li {
    background: #f1f3f5;
    border: 1px solid #e9e9e9;
    transition: 0.3s;
}

.dep2 > ul > li > a {
    display: block;
    padding: 15px 20px;
    font-size: 18px;
    font-weight: 700;
    color: #0d47a1;
    text-align: center;
}

.dep2 > ul > li:hover {
    background: #0d47a1;
    border-color: #0d47a1;
}

.dep2 > ul > li:hover > a {
    color: #fff;
}

/* Right Buttons (Repositioned to Absolute for Centered Layout) */
.rightBtn {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-lang {
    display: inline-block;
    border: 1px solid #333;
    color: #333;
    padding: 5px 15px;
    font-size: 0.85rem;
    transition: 0.3s;
}

.btnAllmenu {
    display: none;
    font-size: 26px;
    color: #333;
    cursor: pointer;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    .gnb { display: none; }
    .btnAllmenu { display: block; }
    .logoCentered img { height: 28px; }
    #mainHeader .container.gnbArea { flex-direction: row; justify-content: space-between; height: 60px; }
    .rightBtn { position: static; transform: none; }
}
'@
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
