<?php
class RecommendedBookController extends BaseController
{

	public function index()
	{
		$this->_checkLogged();

		$qdrant = new QdrantLogic();
		$qdrantRecomendations = $qdrant->getRecommendationsBooksId($_SESSION['identity']->id);
		/** @var Book[] $booksRecommended */
		$booksRecommended = [];
		if(!empty($qdrantRecomendations)){
			foreach ($qdrantRecomendations['result'] as $recomendation) {
				array_push($booksRecommended, Book::createById($recomendation['id']));
			}
		}
	
		require_once 'views/recommendedBook/recommended.php';
	}
}
