<?php 
/**
 * Template Name: Font
 */
?>
<ul id='list-icon'>
    <?php $nb_elem_per_page = 200;
    $page = isset($_GET['panigation'])?intval($_GET['panigation']):0;
    include get_template_directory() . '/v2/fonts/fonts.php';
    $number_of_pages = intval(count($fonts)/$nb_elem_per_page)+1;
    foreach (array_slice($fonts, $page*$nb_elem_per_page, $nb_elem_per_page) as $key=>$p) { 
        echo '<li><label>'.$key.'</label>'.$p.'</li>';
    } ?>
</ul>
<ul id='paginator'>
<?php
for($i=1;$i<$number_of_pages;$i++){?>
    <li><a href='<?php echo get_the_permalink();?>?panigation=<?php echo $i;?>'><?php echo $i;?></a></li>
<?php }?>
</ul>
<style>
    #paginator{
        list-style:none;
        margin:0px;
        display:flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    #paginator li{
        margin:10px;
        
    }
    #list-icon{
        list-style:none;
        margin:0px;
        display:flex;
        flex-wrap: wrap;
    }
    #list-icon label{
        width: 100%;
        display: inline-block;
        margin-bottom:10px;
    }
    #list-icon li {
        width: 100px;
        text-align: center;
        margin: 10px;
        border: 1px solid;
        padding: 10px;
        height: 80px;
        
    }
    
    #list-icon li svg{
        width: 20px;
    }
</style>