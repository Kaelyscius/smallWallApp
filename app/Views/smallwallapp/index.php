<?php if ($errors):?>
    <div class="alert alert-danger">
        <p>Attention : Vous n'avez pas rempli tous les champs</p>
        <p> Les erreurs suivantes ont été trouvées</p>
        <ul>
        <?php foreach ($errors as $error) : ?>

             <li><?= $error?></li>  
              
        <?php endforeach;?>
        </ul>

    </div>
<?php endif;?>
<div class="row">
    <h1>The Wall</h1>

    <form action="?p=netkin.add" method="POST">
        <input type="hidden" name="formid" value="<?= $_SESSION["formid"]; ?>" />
        <?=$form->input('username', '', ['placeholder' => 'Votre pseudo...']);?>
        <?=$form->input('message', '', ['type'        => 'textarea',
                                        'placeholder' => 'Entrer votre message ici, sans oublier de choisir les categories ! ']);?>
        <div class="col-md-11 divCheckbox">
            <?=$form->checkbox('title', $categories, true);?>
        </div>
         <div class="col-md-1 divSubmit">
            <button type="submit" name="submit">Publier</button>
        </div>

        
    </form>
</div>
<div class="row">
    <?php foreach ($messages as $message): ?>
           <div class="col-md-12 messages">
           <hr>
               <p class="info">
                    <?= $message->username;?> le : <?= date("d/m/Y", strtotime($message->date));?> Catégorie(s) : 
                    <?=implode(', ', $messagescategories[$message->id_message])?>
               </p>

               <p><?= $message->message;?></p>
           </div>
    <?php endforeach?>
</div>