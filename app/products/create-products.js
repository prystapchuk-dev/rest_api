JQuery(function($){
    $(document).on('click', '.create-product-button', function(){
        $.getJSON("http://rest-api/api/product/read.php", function(data){
            var categoriws_options_html = `<select name='category_id' class="form-control">`;
            $.each(data.records, function(key, val) {
                categoriws_options_html += `<option value='` + val.id + `'>` + val.name +`</option>`;
            });
            categoriws_options_html += `</select>`;

            var create_products_html = `<div id='read-products' class="btn btn-primary pull-right m-b-15px read-products-button">
                                            <span class='glyphicon glyphicon-list'></span> Все товары
                                        </div> 
                                        <form id="create-product-form" action="#" method="post" border="0">
                                            <table class="table table-hover table-responsive table-bordered">
                                                <tr>
                                                    <td>Название</td>
                                                    <td><input type="text" name="name" class="form-control" required></td>
                                                </tr> 
                                                <tr>
                                                    <td>Цена</td>
                                                    <td><input type="text" name="price" class="form-control" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Описание</td>
                                                    <td><textarea type="text" name="description" class="form-control" required></textarea></td>
                                                </tr>  
                                                <tr>
                                                    <td>Описание</td>
                                                    <td>` + categoriws_options_html + `</td>
                                                </tr>   
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <button type="submit" class="btn btn-primary">
                                                            <span class="glyphicon gliphicon-plus"></span> Создать товар
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>`;

            $('#page-content').html(create_products_html);

            changePageTitle("Создание товара");
        });

        $(document).on('submit', '#create-product-form', function() {
            var form_data = JSON.stringify($(this).serializeObject());

            $.ajax({
                url: "http://rest-api/api/product/create.php",
                type: "POST",
                contentType: "application/json",
                data: form_data,
                success: function() {
                    showProducts();
                },
                error: function(xhr, resp, text) {
                    console.log(xhr,resp,text);
                }
            });
        return false;
        });
    });
})