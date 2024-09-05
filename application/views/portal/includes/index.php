<?php
  $admin_logo = $this->model->getRow('tb_admin',['id'=>'1']);
  if(!empty($admin_logo))
  {
      $data['admin_logo'] = IMGS_URL.$admin_logo->photo;
      
  }else
  {
 $data['admin_logo'] = base_url() . 'assets/photo/noimage/logo2.png';
  }
 $this->load->view('portal/includes/header',$data);
 $this->load->view($page);
 $this->load->view('portal/includes/footer',$data);
 ?>