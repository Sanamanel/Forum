<?php
session_start();
ob_start();
require('connect.php');
include('header.php');

 if(isset($_SESSION['id'])) {
   if(isset($_POST['tsubmit'])) {
      if(isset($_POST['title'],$_POST['content'])) {
         $sujet = htmlspecialchars($_POST['title']);
         $contenu = htmlspecialchars($_POST['content']);
         if(!empty($sujet) AND !empty($contenu)) {
            if(strlen($sujet) <= 70) {
               $ins = $sql->prepare('INSERT INTO `topics` (`title`, `creation_date`, `content`, `board_id`, `topic_by`) VALUES(?,NOW(),?,?,?');
               $ins->execute(array($sujet,$contenu,$_GET['board_id'],$_SESSION['id']));
            } else {
               $terror = "Votre sujet ne peut pas dépasser 70 caractères";
            }
         } else {
            $terror = "Veuillez compléter tous les champs";
         }
      }
   }
} else {
   $terror = "Veuillez vous connecter pour poster un nouveau topic";
}
?>
<form method="POST" action='#'>
   <table>
      <tr>
         <th colspan="2">New Topic</th>
      </tr>
      <tr>
         <td>Topic Title</td>
         <td><input type="text" name="title" size="70" maxlength="70" /></td>
      </tr>
         <td>Content</td>
         <td><textarea name="content"></textarea></td>
      </tr>
      <tr>
         <td colspan="2"><input type="submit" name="tsubmit" value="Poster le Topic" /></td>
      </tr>
      <?php if(isset($terror)) { ?>
      <tr>
         <td colspan="2"><?= $terror ?></td>
      </tr>
      <?php } ?>
   </table>
</form>
<?php
include('footer.php');
?>