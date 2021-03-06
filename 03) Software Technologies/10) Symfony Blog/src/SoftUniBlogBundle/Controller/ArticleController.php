<?php
namespace SoftUniBlogBundle\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\Tag;
use SoftUniBlogBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class ArticleController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/article/create", name="article_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param int $id
     *
     * @Route("/article/{id}", name="article_view")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function viewArticle($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        if ($article == null) {
            return $this->redirectToRoute("blog_index");
        }

        return $this->render('article/article.html.twig',
            array('article' => $article));
    }

    /**
     * @Route ("/article/edit/{id}", name="article_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editArticle($id, Request $request)
    {
        $article = $this->getDoctrine()->getRepository(Article::Class)->find($id);

        if ($article == null) {
            return $this->redirectToRoute("blog_index");
        }

        $user = $this->getUser();

        if (!$user->isAuthor($article) && !$user->isAdmin()){

            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $this->getDoctrine()->getManager();
            $data->persist($article);
            $data->flush();

            return $this->redirectToRoute('article_view',[
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        if ($article == null){
            return $this->redirectToRoute('blog_index');
        }

        $user = $this->getUser();

        if(!$user->isAuthor($article) && !$user->isAdmin())
        {
            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/delete.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/article/confirm/{id}", name="article_confirm_delete")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function confirmDelete($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        if ($article != null){
            $data = $this->getDoctrine()->getManager();
            $data->remove($article);
            $data->flush();
        }

        return $this->redirectToRoute('blog_index');
    }
}
