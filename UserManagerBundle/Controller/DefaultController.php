<?php

namespace Warden\UserManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Deeson\WardenBundle\Services\UserProviderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
    
    public function indexAction()
    {   
        $securityConfigurationFile = $this->get('kernel')->getRootDir().'/config/warden-security.yml';
        $users = Yaml::parse(file_get_contents($securityConfigurationFile));
        return $this->render('WardenUserManagerBundle:Default:index.html.twig',$users);
    
    }
    public function Add_UserAction(Request $request){
        $username = $request->request->get('user_name');
        $password = $request->request->get('user_pass');

        $message = $this->create_new_user($username, $password);
        return $this->indexAction();
    }

    public function create_new_user($username,$password){
        try{
            $securityConfigurationFile = $this->get('kernel')->getRootDir().'/config/warden-security.yml';
            $users_config_file = Yaml::parse(file_get_contents($securityConfigurationFile));
            $users_data=array();
            foreach ($users_config_file['users'] as $name => $userData)
                $users_data[$name]=$userData;

            //add new user
            $users_data[$username]= array(
                'pass' => hash('sha512', $password),
                'roles' => array(
                'ROLE_USER'
                )
            );
            $users_config_data = array(
                'users' => $users_data
            );
            $siteConfig = Yaml::dump($users_config_data);
            file_put_contents($securityConfigurationFile, $siteConfig);
            return true;
            }catch (Exception $e){
                return false;
            }
    }

    /**** Delete user */
    public function Del_UserAction(Request $request){
        $username = $request->request->get('user_name');
        $securityConfigurationFile = $this->get('kernel')->getRootDir().'/config/warden-security.yml';
        $users_config_file = Yaml::parse(file_get_contents($securityConfigurationFile));
        $users_data=array();

        foreach ($users_config_file['users'] as $name => $userData){
            if($name!=trim($username))
                $users_data[$name]=$userData;
        }
        $users_config_data = array(
            'users' => $users_data
        );
        $siteConfig = Yaml::dump($users_config_data);
        file_put_contents($securityConfigurationFile, $siteConfig);
        return $this->indexAction();
    }
}
