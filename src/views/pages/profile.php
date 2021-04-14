<?= $render('header', ['loggedUser'=>$loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'profile']);?>
    <section class="feed">

            <div class="row">
                <div class="box flex-1 border-top-flat">
                    <div class="box-body">
                        <div class="profile-cover" style="background-image: url('<?=$base;?>/media/covers/<?=$user->cover;?>');"></div>
                        <div class="profile-info m-20 row">
                            <div class="profile-info-avatar">
                                <img src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
                            </div>
                            <div class="profile-info-name">
                                <div class="profile-info-name-text"><?=$user->name;?></div>
                                <div class="profile-info-location"><?=$user->city;?></div>
                            </div>
                            <div class="profile-info-data row">
                                <!-- Botao seguir--->
                                <?php if($user->id != $loggedUser->id): ?>
                                <div class="profile-info-item m-width-20">
                                    <?php if($isFollowing): ?>
                                        <a href="#" class="button">Deixar de Seguir</a>
                                    <?php else: ?>    
                                        <a href="#" class="button">Seguir</a>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->followers);?></div>
                                    <div class="profile-info-item-s">Seguidores</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->following);?></div>
                                    <div class="profile-info-item-s">Seguindo</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->photos);?></div>
                                    <div class="profile-info-item-s">Fotos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">

                <div class="column side pr-5">
                    
                    <div class="box">
                        <div class="box-body">
                            
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/calendar.png" />
                                <?=date('d/m/Y', strtotime($user->birthdate));?> (<?=$user->ageYears;?> anos)
                            </div>

                            <?php if(!empty($user->city)): ?>
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/pin.png" />
                                <?=$user->city;?>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($user->work)): ?>
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/work.png" />
                                <?=$user->work;?>
                            </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?=count($user->following);?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">
                            <!--Seguindo-->
                            <!--mostra apenas 9 usuarios-->
                            <?php for($x=0;$x<9;$x++): ?>
                                <?php if(isset($user->following[$x])): ?><!--confere se tem esse quantidade de usuarios antes de mostrar-->
                                    <div class="friend-icon">
                                        <a href="<?=$base;?>/perfil/<?=$follower[$x]->id;?>">
                                            <div class="friend-icon-avatar">
                                                <img src="<?=$base;?>/media/avatars/<?=$follower[$x]->avatar;?>" />
                                            </div>
                                            <div class="friend-icon-name">
                                                <?=$follower[$x]->name;?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?=count($user->photos);?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            
                            <?php for($x=0;$x<4;$x++): ?>
                                <?php if(isset($user->photos[$x])): ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?=$user->photos[$x]->id;?>" rel="modal:open">
                                            <img src="<?=$base;?>/media/uploads/<?=$user->photos[$x]->body;?>" />
                                        </a>
                                        <div id="modal-<?=$user->photos[$x]->id;?>" style="display:none">
                                            <img src="<?=$base;?>/media/uploads/<?=$user->photos[$x]->body;?>" />
                                        </div>
                                    </div>
                                    
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                        </div>
                    </div>
                    <!-- mostra editor de novo feed -->
                    <?php if($user->id == $loggedUser->id): ?>
                        <?= $render('feed-editor', ['user'=>$loggedUser]); ?>
                    <?php endif; ?>

                    <?php foreach($feed['posts'] as $feedItem): ?>

                        <?= $render('feed-item', [
                            'data' => $feedItem,
                            'loggedUser' => $loggedUser
                        ]); ?>

                    <?php endforeach; ?>
                    <!--  numero de paginas -->
                    <div class="feed-pagination">
                        <?php for($q=0;$q<$feed['pageCount'];$q++): ?>
                            <a class="<?=($q==$feed['currentPage']?'active':'')?>" href="<?=$base;?>/perfil/<?=$user->id?>?page=<?= $q;?>"><?=$q+1;?></a>
                        <?php endfor; ?>
                    </div>


                </div>
                
            </div>

        </section> 

</section>
<?= $render('footer'); ?>