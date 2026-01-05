<?php
include_once('./common.php');
$table_name = "g5_plugin_main_image_add";

echo "Updating empty ultimate_hero data...\n";
$sql = " update {$table_name}
            set mi_image = 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=2574&auto=format&fit=crop',
                mi_title = 'THE ESSENCE OF <br>MINIMALISM',
                mi_desc = 'We pursue the essential value that does not change even in the flow of digital.',
                mi_link = '#',
                mi_sort = 1,
                mi_video = ''
            where mi_style = 'ultimate_hero' and (mi_image = '' or mi_title = '') ";
sql_query($sql);
echo "Done.\n";
?>