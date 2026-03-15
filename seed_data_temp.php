<?php
include_once('./common.php');

$table_name = "g5_plugin_main_image_add";

// Check if ultimate_hero has data
$cnt = sql_fetch(" select count(*) as cnt from {$table_name} where mi_style = 'ultimate_hero' ");

if ($cnt['cnt'] == 0) {
    echo "Seeding ultimate_hero data...\n";
    $sql = " insert into {$table_name}
                set mi_style = 'ultimate_hero',
                    mi_image = 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=2574&auto=format&fit=crop',
                    mi_title = 'THE ESSENCE OF <br>MINIMALISM',
                    mi_desc = 'We pursue the essential value that does not change even in the flow of digital.',
                    mi_link = '#',
                    mi_sort = 1,
                    mi_video = '' ";
    sql_query($sql);
    echo "Done. Please check the main page.\n";
} else {
    echo "Data already exists for ultimate_hero.\n";
}
?>