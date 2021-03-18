<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?= $base; ?>/media/avatars/<?= $user->avatar;?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?= $user->name; ?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-send">
                <img src="<?= $base; ?>/assets/images/send.png" />
            </div>

            <form class="feed-new-form" action="<?=$base;?>/post/new" method="post">
                <input type="hidden" name="body">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
//feed não é um formulario, ele é uma div totalmente editavel
//script pra pegar o que o usuario digitou no feed e enviar para o formulario invisivel
let feedInput = document.querySelector('.feed-new-input');
let feedSubmit = document.querySelector('.feed-new-send');
let feedForm = document.querySelector('.feed-new-form');

feedSubmit.addEventListener('click', function(obj){
    let value = feedInput.innerText.trim(); //pega valor e remove os espaços de antes e depois do texto

    if(value != ''){
        feedForm.querySelector('input[name=body]').value = value;
        feedForm.submit();
    }
});
</script>
