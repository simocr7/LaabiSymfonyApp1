<?php
namespace simo\projetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use simo\projetBundle\Entity\Singe;

class DefaultController extends Controller
{
    

     /**
     * @Route("/ajouter",name="add")
     */
    public function ajouterAction(Request $req )
      { 
           $s=new Singe();
           $form=$this->createFormBuilder($s)
                ->add('age', TextType::class)
                ->add('famille', TextType::class)
                ->add('race', TextType::class)
                ->add('nourriture', TextType::class)
                ->add('Enregister',SubmitType::class)
                ->getForm();
                     $form->handleRequest($req);
                                                if($form->isValid()){
                                                                      $em=$this->getDoctrine()->getManager();
                                                                      $em->persist($s);
                                                                      $em->flush();
                                                                      return $this->render('simoprojetBundle:bonoboViews:index.html.twig');
                                                                    }
                                                $bono=$this->getDoctrine()->getRepository("simoprojetBundle:Singe")->findAll();
                                                return $this->render('simoprojetBundle:bonoboViews:ajouterBonobo.html.twig',array('f' => $form->createView(),'bonobo'=>$bono));
    }
    
    
 /**
 * @Route("/",name="mo") 
 */
  
  public function indexAction() {
                                      return $this->render('simoprojetBundle:bonoboViews:index.html.twig');
                                }
 
    
 /**
 * @Route("/modifier/{id}",name="update") 
 */
  
  public function modifierAction(Request $req,$id) {
           $em=$this->getDoctrine()->getManager();
        $bono=$em->getRepository('simoprojetBundle:Singe')->find($id);
         $form=$this->createFormBuilder($bono)
                ->add('age', TextType::class)
                ->add('famille', TextType::class)
                ->add('race', TextType::class)
                ->add('nourriture', TextType::class)
                ->add('Modifier',SubmitType::class)
                ->getForm();
         $form->handleRequest($req);
        if($form->isValid()){
         $em->merge($bono);
           $em->flush();
        }  
              return $this->render('simoprojetBundle:bonoboViews:modifier.html.twig',array('f' => $form->createView(),'bonobo'=>$bono));

  }      
                 
     /**
     * @Route("/delete/{id}",name="delete")
     */
    public function SupprimerAction(Request $req , $id)
    {
        $em=$this->getDoctrine()->getManager();
        $bono=$em->getRepository('simoprojetBundle:Singe')->find($id);
         $form=$this->createFormBuilder($bono)
                ->add('age', TextType::class)
                ->add('famille', TextType::class)
                ->add('race', TextType::class)
                ->add('nourriture', TextType::class)
                ->add('Supprimer',SubmitType::class)
                ->getForm();
         $form->handleRequest($req);
        if($form->isValid()){
         $em->remove($bono);
        $em->flush();
         return $this->redirect($this->generateUrl("list"));
         }
        
      return $this->render('simoprojetBundle:bonoboViews:supprimer.html.twig',array('f' => $form->createView(),'bonobo'=>$bono));
      
    }
                                 
     /**
     * @Route("/listez",name="list")
     */
     public function ListezAction()
    {  
         
        $bono=$this->getDoctrine()->getRepository("simoprojetBundle:Singe")->findAll();
        return $this->render('simoprojetBundle:bonoboViews:Listez.html.twig',array('bonobo' => $bono));
      
    }   
    
    /**
     * @Route("/account",name="login")
     */
     public function accountAction(Request $req)
     { 
         if($req->getMethod()=='POST')
             {
                 $login=$req->get('login');
                 $password=$req->get('password');
                 $em=$this->getDoctrine()->getEntityManager();
                 $resp=$em->getRepository('simoprojetBundle:Identification');
                 $user=$resp->findOneBy(array('login'=>$login,'password'=>$password));
               
                    if($user){
                                 return $this->redirect($this->generateUrl("welcome"));
                              }
                    else{
                          return $this->redirect($this->generateUrl("login"));
                    }
                      
             }
       return $this->render('simoprojetBundle:bonoboViews:account.html.twig');
     }
     
         
    /**
     * @Route("/Bienvenue",name="welcome")
     */
     public function welcomeAction(Request $req)
     { 
        return $this->render('simoprojetBundle:bonoboViews:welcome.html.twig'); 
     }                        
}