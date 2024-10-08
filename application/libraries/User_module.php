<?php
/**
 * 
 */
class User_module 
{	
	  
	function __construct() {
	    $CI =& get_instance();
	}

	function get_menu($user)
	{
		$CI =& get_instance();
			$user_id = $user->id;
			$user_role = $user->user_role;
			if ($role=$CI->db->get_where('tb_user_role',array('id'=>$user_role))->row()) {
				$role_id=$role->id;
				$role_title=$role->name;
			}
			else{
				return false;
			}
		if($menu=$this->getMenu($role_id,$role_title))
		{
			$all_menus = $CI->db->get_where('tb_admin_menu',array('status' => 1 ))->result();
			return $this->printMenu_v($menu,$all_menus,$user_role);
		}
		else
		{
			return false;
		}
	}
	public function get_submenu_data($menu_id,$role_id)
    {
		$CI =& get_instance();
        $CI->db->
        select('t1.*')
        ->from('tb_admin_menu t1')
        ->join('tb_role_menus t2', 't2.menu_id = t1.id')
        ->where('t2.role_id',$role_id)
        ->where('t1.parent',$menu_id)
        ->where('t1.status','1')
        ->order_by('t1.title','ASC');

        return $CI->db->get()->result();
    }

	private function printMenu_v($menu,$all_menus,$user_role)
	{
		// class="active"

		$current_url=trim(str_replace(base_url(),' ',current_url()));
		$printmenu='';
		// Nav Item - Dashboard
		$dasActive = '';
		if ($current_url=='' or $current_url=='dashboard' or $current_url=='dashboard/index') {
			$dasActive = 'active';
		}
		// echo $current_url;
		$printmenu.='<li class="nav-item '.$dasActive.'">';
            $printmenu.='<a href="'.base_url('dashboard').'">';
                $printmenu.='<i class="ft-home"></i>';
                $printmenu.='<span class="menu-title" data-i18n="">Dashboard</span>';
            $printmenu.='</a>';
        $printmenu.='</li>';



		
		// Nav Item - Dashboard 
		foreach ($menu as $row) {
			 //memu
			($current_url==$row->url) ? $active = 'active' : $active = '';
			if ($row->parent==0 or $row->parent=='0' or $row->parent=='') {
				
				if ($submenu1=$this->getSubMenu($all_menus,$row->id,$user_role)) {
					$printmenu.='<li class="nav-item ">';
		                $printmenu.='<a href="#">';
		                    $printmenu.='<i class="'.$row->icon_class.'"></i>';
		                    $printmenu.='<span class="menu-title" data-i18n="">';
		                    $printmenu.= $row->title;
		                $printmenu.='</a>';

		                $printmenu.='<ul class="menu-content">';
		                	foreach ($submenu1 as $row1) {
		                	($current_url==$row1->url) ? $sactive = 'active' : $sactive = '';
		                        $printmenu.='<li class="'.$sactive.'">';
			                        $printmenu.='<a class="menu-item" href="'.base_url().$row1->url.'">';
			                            $printmenu.= $row1->title;
			                        $printmenu.='</a>';
			                    $printmenu.='</li>';
		                	}
		                $printmenu.='</ul>';
		            $printmenu.='</li>';

				}
				else
				{
					
					$printmenu.='<li class=" nav-item '.$active.'">';
			            $printmenu.='<a href="'.base_url().$row->url.'">';
			                $printmenu.='<i class="'.$row->icon_class.'"></i>';
			                $printmenu.='<span class="menu-title" data-i18n="">'.$row->title.'</span>';
			            $printmenu.='</a>';
			        $printmenu.='</li>';
					
				}
			}
			
		}

		return $printmenu;
	}

	function getSubMenu($menu,$id,$user_role)
	{
		$menu=$this->get_submenu_data($id,$user_role);
		$submenu=array();
		foreach ($menu as $row) {
			if ($row->parent==$id) {
				$submenu[]=$row;
			}
		}
		if (count($submenu)>0) {
			return $submenu;
		}
		return false;
	}


	// get menu
	private function getMenu($role_id,$role_title){
		$CI =& get_instance();
		if ($role_title=='developer') {
				$CI->db->order_by('indexing','asc');
				if($menu=$CI->db->get_where('tb_admin_menu', array('status' => 1 ))){
					return $menu->result();
				}
			else{
				return false;
			}
		}
		else{
			$menu_ids='';
			if($menus=$CI->db->get_where('tb_role_menus',array('role_id'=>$role_id))){
				foreach ($menus->result() as $key => $row) {
						$menu_ids .= ' '.trim($row->menu_id);
				}
				$menu_ids=trim($menu_ids);
				$functions= array();
				$function = explode(" ",$menu_ids);
				foreach ($function as $row) {
					if($ff=$CI->db->get_where('tb_admin_menu',array('id'=>$row,'status'=>1))->row())
					{
						$functions[]=$ff;
					}
				}
				return $functions;
			}
			else{
				return false;
			}
		}
	}
	// get menu
}

?>
