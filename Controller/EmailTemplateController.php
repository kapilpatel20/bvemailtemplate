<?php

namespace BviTemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BviMailerBundle\Entity\EmailTemplate;
use Symfony\Component\HttpFoundation\Response;
use BviTemplateBundle\Form\Type\EmailTemplateFormType;

class EmailTemplateController extends Controller
{
    public function indexAction()
    {
        return $this->render('BviTemplateBundle:EmailTemplate:index.html.twig', array(
                // ...
            ));    
    }
    
    public function emailTemplateListJsonAction($orderBy = "id", $sortOrder = "asc", $search = "all", $offset = 0) 
    {
        $aColumns = array('Id', 'Key', 'Subject', 'Status', 'CreatedAt', 'UpdatedAt');

        $admin = $this->get('security.context')->getToken()->getUser();
        
        $grid_utils = $this->get('bvi_template.grid');
        $gridData = $grid_utils->getSearchData($aColumns);

        $sortOrder = $gridData['sort_order'];
        $orderBy = $gridData['order_by'];
        
        if ($gridData['sort_order'] == '' && $gridData['order_by'] == '') {
            
            $orderBy = 'a.id';
            $sortOrder = 'DESC';
        } else {
            
            if ($gridData['order_by'] == 'Key') {
                
                $orderBy = 'a.emailkey';
            }
            if ($gridData['order_by'] == 'Subject') {
                
                $orderBy = 'a.subject';
            }
            if ($gridData['order_by'] == 'Status') {
                
                $orderBy = 'a.status';
            }
            if ($gridData['order_by'] == 'CreatedAt') {
                
                $orderBy = 'a.createdAt';
            }
            if ($gridData['order_by'] == 'UpdatedAt') {
                
                $orderBy = 'a.updatedAt';
            }
            if ($gridData['order_by'] == 'Id') {
                
                $orderBy = 'a.id';
            }
        }

        // Paging
        $per_page = $gridData['per_page'];
        $offset = $gridData['offset'];

        $em = $this->getDoctrine()->getManager();
        
        $data  = $em->getRepository('BviTemplateBundle:Emailtemplate')->getEmailTemplateGridList($per_page, $offset, $orderBy, $sortOrder, $gridData['search_data'], $gridData['SearchType'], $grid_utils);
        
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );
        if (isset($data) && !empty($data)) {
            
            if (isset($data['result']) && !empty($data['result'])) {
                
                $output = array(
                    "sEcho" => intval($_GET['sEcho']),
                    "iTotalRecords" => $data['totalRecord'],
                    "iTotalDisplayRecords" => $data['totalRecord'],
                    "aaData" => array()
                );
                
                foreach ($data['result'] AS $resultRow) {
                    
                    $row = array();
                    $row[] = $resultRow->getId();
                    $row[] = $resultRow->getEmailkey();
                    $row[] = $resultRow->getSubject();
                    $row[] = $resultRow->getId();
                    $output['aaData'][] = $row;
                }
            }
        }

        $response = new Response(json_encode($output));
	$response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function newAction(Request $request, $id = '') {
        
        $em = $this->getDoctrine()->getManager();
    	$admin = $this->get('security.context')->getToken()->getUser();
        
        if ($id != '') {
            $objEmailTemplate = $em->getRepository('BviTemplateBundle:Emailtemplate')->find($id);
            if (!$objEmailTemplate) {
                $this->get('session')->getFlashBag()->add('failure', "Email template does not exist.");
                return $this->redirect($this->generateUrl('index'));
            }
        } else {

            $objEmailTemplate = new Emailtemplates();
        }

        $form = $this->createForm(new EmailTemplateFormType(), $objEmailTemplate);

        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $objEmailTemplate->setStatus('Active');
              
                $em->persist($objEmailTemplate);
                $em->flush();

                if ($id != '') {

                    $this->get('session')->getFlashBag()->add('success', "Email template updated successfully.");
                } else {

                    $this->get('session')->getFlashBag()->add('success', "Email template added successfully.");
                }

                return $this->redirect($this->generateUrl('index'));
            }
        }
        return $this->render('BviTemplateBundle:EmailTemplate:new.html.twig', array(
                    'form' => $form->createView(),
                    'emailTemplate' => $objEmailTemplate
        ));
    }

}
