<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'auth/login' => array(        
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        )
    ),
    'auth/register' => array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|alpha_numeric_spaces|max_length[100]'
        ),
        array(
            'field' => 'age',
            'label' => 'Age',
            'rules' => 'numeric|is_natural'
        ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'in_list[male,female]'
        ),
        array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => 'max_length[300]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email|strtolower|max_length[256]'
        )
    )
);

$config['error_prefix'] = '<div class="alert alert-danger" role="alert">';
$config['error_suffix'] = '</div>';
