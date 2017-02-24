<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function manageUsersAction(Request $request)
    {
        $request = Request::createFromGlobals();
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $users = $userManager->findUsers();

        //var_dump($users);die();

        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {

            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();

            if(isset($_POST['edit'])){

                $em->flush();
                $this->addFlash('info', 'User edited successfully');
                return $this->redirectToRoute('admin_manage_users');
                die();
            }
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', 'User added successfully');
            return $this->redirectToRoute('admin_manage_users');
        }
        return $this->render('admin/manage_users.html.twig', array(
            'form'  => $form->createView(),
            'users' => $users
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editAjaxAction(Request $request)
    {
        if($request->isXmlHttpRequest()){

            $id = $_POST['id'];
            $userManager = $this->get('fos_user.user_manager');
            $users = $userManager->findUsers();
            foreach ($users as $currentUser){
                if($currentUser->getId() == $id){
                    $user = $currentUser;
                }
            }

            $return['id'] = $user->getId();
            $return['fullname'] = $user->getFullname();
            $return['username'] = $user->getUsername();
            $return['email']    = $user->getEmail();
            $return['city']    = $user->getCity();
            $return['coutnry']    = $user->getCountry();
            $return['address']    = $user->getAddress();
            //$return = array('user'=>$user);

            return new Response(json_encode($return));
        }
    }

    /**
     * @param Request $request
     */
    public function deleteAjaxAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $id = $_POST['id'];
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserBy(array('id'=>$id));
            $userManager->deleteUser($user);

            return new Response(json_encode(array('id'=>$id)));
        }
    }
}
