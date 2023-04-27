<!-- <//?php 

namespace Models;

$content = file_get_contents("php://input");
$data = json_decode($content, true); // $data = 5;
$query = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
$query->execute([$data['id']]);
$article = $query->fetch();
include 'articles.phtml';

class getArticle extends Database{


        
} -->
