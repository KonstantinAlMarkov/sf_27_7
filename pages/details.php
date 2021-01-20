<div class="row fileListH">
    <div class="col-12">
        <h2>Изображение:<?php echo $image ?></h2>
        <hr>
    </div>           
</div>
<div class="row justify-content-center imgRow">
    <img src="<?php echo UPLOAD_DIR. '/' .$image;?>" class="img-thumbnail" alt="<?php echo URL.UPLOAD_DIR. '/' .$fileName;?>">
</div>
<div class="row comments">
    <div class="col-12"><hr>
        <div class="row commentsList">
            <div class="col-md-12">
                <div class="row">
                    <h2>Комментарии:</h2><br>
                </div>
                <?php if (!count($data)>0):?>
                    <h3>Комментариев пока что нет</h3>
                <?php endif; ?>
                <?php if (count($data)>0):?> 
                    <ul>                       
                        <?php 
                            foreach($data as $string):?>  
                            <li>
                                <form method="POST">
                                    <input type="hidden" name="commentToDelete" value="<?php echo $string;?>">
                                    <button type="submit" class="close" aria-label="Удалить" id="deleteComment">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </form>   
                                <?php echo $string; ?> 
                            </li>    
                        <?php endforeach; ?> 
                    </ul> 
                <?php endif;?>        
            <div>
        </div>
        <div class="row comment form">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <label for="commentField">Дайте свой комментарий:</label>
                        <textarea class="form-control" id="FormControlTextarea" rows="3" name="comment"></textarea>
                    </div>
                    <input name="submit" type="submit" value="Комментировать">
                </form>
            </div>
        <div> 
    </div>
</div>