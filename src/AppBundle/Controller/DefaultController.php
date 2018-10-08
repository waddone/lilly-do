<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\RouteCollection;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\AddressBook;
use AppBundle\Form\AddressBookType;
use AppBundle\Repository\AddressBookRepository;
use AppBundle\Service\FileUploader;

//use Symfony\Component\HttpFoundation\File\Exception\FileException;


class DefaultController extends Controller
{

    /**
     * @Route("/", name="overview", methods="GET|POST")
     * @param AddressBookRepository $addressBookRepository
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     * @throws \Exception
     */

    public function indexAction(Request $request, FileUploader $fileUploader, AddressBookRepository $addressBookRepository): Response
    {

        $addressBook = new AddressBook();
        $form = $this->createForm(AddressBookType::class, $addressBook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $obj = $this->getDoctrine()->getManager();
            $obj->persist($addressBook);
            $obj->flush();
            return $this->redirectToRoute('overview');
        }

        return $this->render('overview/index.html.twig', 
            [
                'address_book_c' => $addressBookRepository->findAll(),
                'address_book'   => $addressBook,
                'form'           => $form->createView()
            ]
        );
    }

    /**
     * @Route("/address-book/{id}/edit", name="edit", methods="POST")
     * @param Request $request
     * @param AddressBook $addressBook
     * @return Response
     */
    
    public function edit(Request $request, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $addressBook = $em->getRepository('AppBundle:AddressBook')->find($id);
        $addressBook->setFirstname($request->request->get('firstname'));
        $addressBook->setLastname($request->request->get('lastname'));
        $addressBook->setStreetAndNumber($request->request->get('streetAndNumber'));
        $addressBook->setZip($request->request->get('zip'));
        $addressBook->setCity($request->request->get('city'));
        $addressBook->setCountry($request->request->get('country'));
        $addressBook->setPhonenumber($request->request->get('phonenumber'));
        $addressBook->setBirthday(\DateTime::createFromFormat('Y-m-d', $request->request->get('birthday')));
        $addressBook->setEmailAddress($request->request->get('emailAddress'));    
        $em->persist($addressBook);
        $em->flush();
        return $this->redirectToRoute('overview');
    }


    /**
     * @Route("/{id}/view", name="view", methods="GET|POST")
     * @param AddressBook $addressBook
     * @return Response
     */
    public function view(Request $request, AddressBook $addressBook, FileUploader $fileUploader): Response
    {
      
        $form = $this->createForm(AddressBookType::class, $addressBook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($addressBook);
            $em->flush();
            return $this->redirectToRoute('view', ['id' => $addressBook->getId()]);
        
        }

        return $this->render('overview/view.html.twig', 
            [
                'address_book' => $addressBook,
                'form'         => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{id}/delete", name="delete", methods="DELETE")
     * @param Request $request
     * @param AddressBook $addressBook
     * @return Response
     */
    public function delete(Request $request, AddressBook $addressBook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$addressBook->getId(), $request->request->get('_token'))) {
            $obj = $this->getDoctrine()->getManager();
            $obj->remove($addressBook);
            $obj->flush();
        }
        return $this->redirectToRoute('overview');
    }


    


}

