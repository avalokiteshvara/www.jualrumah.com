<?php
if (!function_exists('load_image')) {
    function load_image($image_path, $width, $height)
    {
        return site_url('Timthumb?src='.site_url($image_path).'&h='.$height.'&w='.$width.'&zc=0');
    }
}

function print_recursive_list($data,$selected_data = NULL)
{
    $str = "";
    foreach($data as $list)
    {
        $str .= $selected_data == $list['id'] ? "<option selected=\"selected\" value= \"" . $list['id'] . "\">" . $list['nama'] . "</option>" :"<option value= \"".$list['id']."\">".$list['nama']."</option>";
        $subchild = print_recursive_list($list['child']);
    }
    return $str;
}

function get_setting($item){
  $CI =& get_instance();

  $CI->db->select("value");
  return $CI->db->get_where("tbl_config",array("item" => $item))->row()->value;
}
