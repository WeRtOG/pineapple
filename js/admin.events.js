$(function() {
    $('[data-confirm]').submit(function(e) {
        const text = $(this).attr('data-confirm');
        const result = window.confirm(text);

        if(!result) e.preventDefault();
    });
    $('form .edit').click(function(e) {
        const oldtext = $(this).parent().find('input[name="name"]').attr('value');
        const newtext = window.prompt('Введите новое название', oldtext);
        $(this).parent().find('input[name="name"]').attr('value', newtext);
        $(this).parent().submit();
        e.preventDefault();
    });
    $('form .edit').parent().find('input').change(function() {
        if($(this).attr('name') != 'name') $(this).parent().submit();
    });
    $('a[href]').click(function(e) {
        if($(this).attr('target') == '_blank') return;
        $('.anix').css('transition', 'all 0.3s ease');
        $('.anix').css('opacity', 0);
    });
    $('#hr-photo-change').on('change', async function() {
        const id = $(this).attr('data-id');
        if(this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('label[for=hr-photo-change]').addClass('loading');
                $('label[for=hr-photo-change]').css('background-image', 'url(' + e.target.result + ')');
            }
            reader.readAsDataURL(this.files[0]);
            const result = await api.UploadHorizontalPhoto(id, this.files[0]);

            $('label[for=hr-photo-change]').removeClass('loading');
            if(!result.ok) {
                if(result.code == 403) {
                    location.reload();
                    return;
                }
                alert("Ошибка загрузки!\nИзображение должно быть в формате JPG, JPEG, PNG или GIF");
            }
        }
    });
    $('#add-photo').on('change', async function() {
        const id = $(this).attr('data-id');
        if(this.files && this.files[0]) {
            $new = $('<div class="photo"></div>');
            $('.photos-list .main-photos').append($new);
            $new.attr('data-id', id);

            var reader = new FileReader();
            reader.onload = function(e) {
                $new.css('background-image', 'url(' + e.target.result + ')');
            }
            
            reader.readAsDataURL(this.files[0]);
            const result = await api.UploadProductPhoto(id, this.files[0]);

            if(!result.ok) {
                if(result.code == 403) {
                    location.reload();
                    return;
                }
                alert("Ошибка загрузки!\nИзображение должно быть в формате JPG, JPEG, PNG или GIF");
            } else {
                $new.attr('data-filename', result.filename);
            }
            $('.photos-list .main-photos').append($new);
        }
    });
    $('html').delegate('.product-edit .photos .photo', 'click', async function() {
        const id = $(this).attr('data-id');
        const filename = $(this).attr('data-filename');

        const confirm = window.confirm('Вы уверены что хотите удалить это фото?');

        if(!confirm) return;

        const result = await api.DeleteProductPhoto(id, filename);
        
        if(!result.ok) {
            if(result.code == 403) {
                location.reload();
                return;
            }
            alert("Ошибка удаления!");
        } else {
            $(this).detach();
        }
        
    });
});