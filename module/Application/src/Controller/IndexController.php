<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Application\Entity\Post;

/**
 * This is the main controller class of the Blog application. The
 * controller class is used to receive user input,
 * pass the data to the models and pass the results returned by models to the
 * view for rendering.
 */
class IndexController extends AbstractActionController {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * Recent Posts page containing the recent blog posts.
     */
    public function indexAction() {

        /*$page = $this->params()->fromQuery('page', 1);
        $tagFilter = $this->params()->fromQuery('tag', null);

        if ($tagFilter) {

            // Filter posts by tag
            $query = $this->entityManager->getRepository(Post::class)
                ->findPostsByTag($tagFilter);

        } else {
            // Get recent posts
            $query = $this->entityManager->getRepository(Post::class)
                ->findPublishedPosts();
        }

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        // Get popular tags.
        $tagCloud = $this->postManager->getTagCloud();

        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager,
            'tagCloud' => $tagCloud
        ]);*/
    }


    //about page
    public function aboutAction() {

        $appName = 'Giới thiệu';
        $appDescription = 'Trang giới thiệu về Eco-Idea';

        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);

    }

    //news page
    public function newsAction() {

        $appName = 'Tin tức';
        $appDescription = 'Trang tin tức của Eco-Idea';

        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);

    }

    //contact page
    public function contactAction() {

        $appName = 'Liên hệ';
        $appDescription = 'Trang liên hệ với Eco-Idea';

        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);

    }

}
