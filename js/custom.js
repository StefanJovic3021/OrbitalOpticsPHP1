const currentUrl = window.location.href;

if (currentUrl.includes("/index.php?login=success"))
{
    $.ajax({
        type: 'GET',
        url: 'php/users.php',
        dataType: 'json',
        success: function(data){
            if (data.id)
            {
                iziToast.show({
                    title: `Logging successful!`,
                    color: 'blue',
                    closeOnClick: true,
                    position: 'topCenter',
                });
            }
        },
        error: function(xhr, status, error)
        {
            console.error(xhr.responseText);
        }
    });
}

if (currentUrl.includes("/index.php?logout=success"))
{
    $.ajax({
        type: 'GET',
        url: 'php/users.php',
        dataType: 'json',
        success: function(data)
        {
            if (!data.id)
            {
                iziToast.show({
                    title: `Logging out successful!`,
                    color: 'blue',
                    closeOnClick: true,
                    position: 'topCenter',
                });
            }
        },
        error: function(xhr, status, error)
        {
            console.error(xhr.responseText);
        }
    });
}

if (currentUrl.includes("/index.php?edit=success"))
{
    $.ajax({
        type: 'GET',
        url: 'php/users.php',
        dataType: 'json',
        success: function(data)
        {
            if (data.id)
            {
                iziToast.show({
                    title: `Account successfully edited!`,
                    color: 'blue',
                    closeOnClick: true,
                    position: 'topCenter',
                });
            }
        },
        error: function(xhr, status, error)
        {
            console.error(xhr.responseText);
        }
    });
}

if (currentUrl.includes("/cartPage.php"))
{
    function ajaxCallback(callbackFunction)
    {
        $.ajax({
            type: 'GET',
            url: 'php/carts_products.php',
            dataType: 'json',
            data: {
                user_id: user_id,
                local_storage_cart: localStorageCart,
            },
            success: function(data)
            {
                callbackFunction(data);
            },
            error: function(xhr, status, error)
            {
                console.error(xhr.responseText);
            }
        });
    }

    let user_id = $('#cartMain').data("uid");
    let localStorageCart = JSON.parse(localStorage.getItem('cart'));

    if(user_id !== 'ls')
    {
        localStorageCart = null;
        ajaxCallback(drawCart);
    }
    else
    {
        ajaxCallback(fixQuantity)
    }

    function drawCart(cartList)
    {
        let cartBlock = document.getElementById("cartPanelTableBody");
        let totalPrice = 0;

        cartBlock.innerHTML = "";

        let index = 1;

        if (cartList.length === 0)
        {
            $('#cartFilled').css('display', 'none');
            $('#cartEmpty').css('display', 'flex');
        }
        else
        {
            $('#cartFilled').css('display', 'flex');
            $('#cartEmpty').css('display', 'none');
            for(let cartItem of cartList)
            {
                cartBlock.innerHTML +=
                    `
                    <tr>
                        <td><p>${index++}</p></td>
                        <td><div class="itemName"><div class="itemPic"><img src="${cartItem.image}" alt="${cartItem.name}" /></div><p>${cartItem.name}</p></div></td>
                        <td><div data-cart_id="${cartItem.id}" data-product_id="${cartItem.product_id}" data-price_id="${cartItem.price_id}" class="itemQuantity"><i class="las la-caret-up upQuantity"></i><p>${cartItem.quantity}</p><i class="las la-caret-down downQuantity"></i></div></td>
                        <td><p>$${Math.round((cartItem.price * cartItem.quantity) * 100) / 100}</p></td>
                        <td><i data-cart_id="${cartItem.id}" data-product_id="${cartItem.product_id}" data-price_id="${cartItem.price_id}" class="las la-trash-alt deleteBtn""></i></td>
                    </tr>
                `;
                totalPrice += (cartItem.price * cartItem.quantity);
            }
            $('#cartPanelBody').children("p").text(`$${Math.round(totalPrice * 100) / 100}`)
        }

        $('.upQuantity').on('click', function()
        {
            upQuantity($(this).parents('div').data('price_id'), $(this).parents('div').data('cart_id'), $(this).parents('div').data('product_id'));
        });

        $('.downQuantity').on('click', function()
        {
            downQuantity($(this).parents('div').data('price_id'), $(this).parents('div').data('cart_id'), $(this).parents('div').data('product_id'));
        });

        $('.deleteBtn').on('click', function()
        {
            deleteProduct($(this).data('price_id'), $(this).data('cart_id'), $(this).data('product_id'));
        });
    }

    function fixQuantity(cartList)
    {
        for(let item of cartList)
        {
            item.quantity = (localStorageCart.filter(x => x.product_id == item.product_id)[0].quantity);
        }
        drawCart(cartList);
    }

    function upQuantity(price_id, cart_id, product_id)
    {
        if(!localStorageCart)
        {
            $.ajax({
                type: 'POST',
                url: 'php/carts_products.php',
                dataType: 'json',
                data: {
                    cart_id: cart_id,
                    product_price_id: price_id,
                },
                success: function (data)
                {
                    console.log("Product successfully added to cart.");
                    ajaxCallback(drawCart);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        else
        {
            for(let product of localStorageCart)
            {
                if (product_id == product.product_id)
                {
                    product.quantity++;
                    localStorage.setItem('cart', JSON.stringify(localStorageCart));
                    ajaxCallback(fixQuantity);
                }
            }
        }
    }

    function downQuantity(price_id, cart_id, product_id)
    {
        if(!localStorageCart)
        {
            $.ajax({
                type: 'DELETE',
                url: `php/carts_products.php?cart_id=${cart_id}&product_price_id=${price_id}`,
                dataType: 'json',
                success: function (data)
                {
                    console.log("Product successfully removed from cart.");
                    ajaxCallback(drawCart);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        else
        {
            for(let product of localStorageCart)
            {
                if (product_id == product.product_id)
                {
                    product.quantity--;
                    if (product.quantity <= 0)
                    {
                        deleteProduct(product.price_id, undefined, product_id);
                    }
                    else
                    {
                        localStorage.setItem('cart', JSON.stringify(localStorageCart));
                        ajaxCallback(fixQuantity);
                    }
                }
            }
        }
    }

    function deleteProduct(price_id, cart_id, product_id)
    {
        if(!localStorageCart)
        {
            $.ajax({
                type: 'DELETE',
                url: `php/carts_products.php?cart_id=${cart_id}&product_price_id=${price_id}&deleteRow=${true}`,
                dataType: 'json',
                success: function (data)
                {
                    console.log("Product row successfully removed from cart.");
                    ajaxCallback(drawCart);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        else
        {
            for(let product of localStorageCart)
            {
                if (product_id == product.product_id)
                {
                    localStorageCart = localStorageCart.filter(x => x.product_id != product_id);
                    localStorage.setItem('cart', JSON.stringify(localStorageCart));
                }
                if (localStorageCart.length == 0)
                {
                    localStorage.removeItem('cart');
                    localStorageCart = null;
                }
                ajaxCallback(fixQuantity);
            }
        }
    }
}

if (currentUrl.includes("/productsPage.php"))
{
    // Fetching and showing products

    let currentPageNumber = 0;
    let searchString = "";
    let checkedCategories = [];
    let sortType = "";
    let viewType = "displayGrid";

    function ajaxCallback(callbackFunction, takeAll = false)
    {
        $.ajax({
            type: 'POST',
            url: 'php/products.php',
            dataType: 'json',
            data: {
                categories: checkedCategories,
                search: searchString,
                sortType: sortType,
                viewType: viewType,
                takeAll: takeAll,
                currentPageNumber: currentPageNumber
            },
            success: function (data) {
                callbackFunction(data);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    let productsBlock = document.getElementById("productShelf");

    function showProducts(data)
    {
        productsBlock.innerHTML = "";
        if(data.length !== 0)
        {
            for (let product of data)
            {
                productsBlock.innerHTML +=
                    `
                    <div class='product ${viewType}'>
                        <div class='productHead'>
                            <img src='${product.image_path}' alt='${product.name}' />
                            <div @click='jumpEditProduct(product)' v-role='['admin']' class='editBtn'>
                                <i class='las la-tools'></i>
                            </div>
                        </div>
                        <div class='productBody'>
                            <div class='productName'>
                                <p>${product.name}</p>
                            </div>
                            <div class='productCompany'>
                                <p>${product.company}</p>
                            </div>
                            <div class='productDesc'>
                                <p>
                                    ${product.description}
                                </p>
                            </div>
                            <div class='productPrice'>
                                <p>$ ${product.price}</p>
                            </div>
                        </div>
                        <div class='productFooter ${(viewType == "displayGrid") ? "" : "displayLineFooter"}'>
                            <div class='addToCartBtn' data-product_id="${product.id}" data-product_name="${product.name}">
                                <p><i class='las la-shopping-cart'></i> Add to cart</p>
                            </div>
                            <div class='moreInfoBtn' data-product_id="${product.id}">
                                <p><i class='las la-info-circle'></i> More info</p>
                            </div>
                        </div>
                    </div>
                `;
            }
            activateProductButtons();
        }
        else
        {
            productsBlock.innerHTML =
                `
                    <div id="productShelfEmpty">
                        <img src="images/graphics/package-box.png" alt="Empty product shelf" />
                        <h3>No product found matching the criteria</h3>
                    </div>
                `;
        }

        ajaxCallback(updatePagination, true);
    }

    ajaxCallback(showProducts);

    function updatePagination(data)
    {
        let productPagePanel = document.getElementById('productPagePanel');
        let totalNumberOfProducts = data.length;
        let totalNumberOfPages = Math. ceil(totalNumberOfProducts / 12);
        productPagePanel.innerHTML = "";

        // Setting up product page number navigation
        if (currentPageNumber > 0)
        {
            productPagePanel.innerHTML += `<div id="buttonLeft"><i class="las la-angle-left"></i></div>`;

        }

        productPagePanel.innerHTML += `<p>${currentPageNumber + 1} / ${totalNumberOfPages}</p>`;

        if ((currentPageNumber + 1) < totalNumberOfPages)
        {
            productPagePanel.innerHTML += `<div id="buttonRight"><i class="las la-angle-right"></i></div>`;

        }

        $('#buttonLeft').on('click', function() {
            currentPageNumber--;
            ajaxCallback(showProducts);
        });
        $('#buttonRight').on('click', function() {
            currentPageNumber++;
            ajaxCallback(showProducts);
        });

        $('html,body').scrollTop(0);
    }

    // Adding to cart

    function activateProductButtons()
    {
        /*
            Two functions: addToCartButtonLogic and showMoreButtonLogic
            Those functions will have their own code.
            > Show more will contact database with ajax to get that exact product
            and return it back to javascript, so it can show more info inside a custom
            modal on screen. It will contain all other buttons like mini showcase
            but with bigger picture, full description and other info a bit more stylized.
        */

        addToCartButtonLogic();
        $('.moreInfoBtn').on('click', function ()
        {
            // Delete this part, it is not done.
            let prodId = $(this).data("product_id");
            iziToast.show({
                title: `Showing more info for product with ID: ${prodId}!`,
                color: 'blue',
                closeOnClick: true,
            });
        });
    }

    function addToCartButtonLogic()
    {
        // Jquery event listener
        $('.addToCartBtn').on('click', function ()
        {
            // Getting product ID from DOM
            let prodId = $(this).data("product_id");
            let prodName = $(this).data("product_name");

            // Contacting php page for user
            $.ajax({
                type: 'GET',
                url: 'php/users.php',
                dataType: 'json',
                success: function (data)
                {
                    // Finding user
                    if (data.id) {
                        checkCart(data.id, prodId);
                    }
                    // User not found, switching to Local Storage
                    else {
                        addToCart("local storage", prodId);
                    }
                    // Toaster popup
                    iziToast.show({
                        title: `${prodName} added to cart!`,
                        color: 'green',
                        closeOnClick: true,
                    });
                },
                error: function (xhr, status, error)
                {
                    console.error(xhr.responseText);
                }
            });
        });
    }

    function checkCart(user_id, prodId)
    {
        // Contacting php page for cart
        $.ajax({
            type: 'GET',
            url: 'php/carts.php',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            success: function (data)
            {
                // Cart found, insert into table `cart_product`
                if (data)
                {
                    addToCart("database", prodId, data.id);
                }
                // Cart not found, insert new cart into `cart` table, then add to `cart_product` table
                else
                {
                    createNewCart(user_id, prodId);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function createNewCart(user_id, prodId)
    {
        // Contacting php page to create new cart for user with user_id
        $.ajax({
            type: 'POST',
            url: 'php/carts.php',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            success: function (data)
            {
                if(data)
                {
                    checkCart(user_id, prodId);
                }
                else
                {
                    console.error("Error while creating cart.");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function addToCart(storageType, product_id, cart_id = 0)
    {
        if(storageType === "database")
        {
            // Contacting php page to get product price id
            $.ajax({
                type: 'GET',
                url: 'php/prices.php',
                dataType: 'json',
                data: {
                    product_id: product_id,
                },
                success: function (data)
                {
                    // Contacting php page to add product to cart
                    $.ajax({
                        type: 'POST',
                        url: 'php/carts_products.php',
                        dataType: 'json',
                        data: {
                            cart_id: cart_id,
                            product_price_id: data.id,
                        },
                        success: function (data)
                        {
                            console.log("Product successfully added to cart.");
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        if(storageType === "local storage")
        {
            let localStorageCart = JSON.parse(localStorage.getItem('cart'));
            let willAddProduct = false;
            // Adding product to local storage
            if (localStorageCart)
            {
                for(let product_row of localStorageCart)
                {
                    if(product_row.product_id == product_id)
                    {
                        product_row.quantity += 1;
                        willAddProduct = false;
                        break;
                    }
                    else
                    {
                        willAddProduct = true;
                    }
                }
                if(willAddProduct)
                {
                    localStorageCart.push({product_id: `${product_id}`, quantity: 1});
                }
                localStorage.setItem('cart', JSON.stringify(localStorageCart));
            }
            else
            {
                let cartJSON = [
                    {product_id: `${product_id}`, quantity: 1}
                ];
                localStorage.setItem('cart', JSON.stringify(cartJSON));
            }
        }
    }

    // Filtering and sorting

    $('.checkboxStyle').children("input").on('change', function(){
        if(this.checked)
        {
            checkedCategories.push(this.value);
        }
        else
        {
            checkedCategories.splice(checkedCategories.indexOf(this.value.toString()), 1);
        }
        ajaxCallback(showProducts);
    });

    $('#searchGlass').on('click', function(){
        let search = document.getElementById("searchInput");
        searchString = search.value;
        ajaxCallback(showProducts);
    });

    $('#sortingDD').on('change', function(){
        sortType = this.value;
        ajaxCallback(showProducts);
    });

    // Change view

    $('#gridView').on('click', function(){
        $('#gridView').children("i").addClass('selected');
        $('#lineView').children("i").removeClass('selected');
        $('.product').addClass('displayGrid').removeClass('displayLine').children(".productFooter").removeClass('displayLineFooter');
        viewType = "displayGrid";
    });

    $('#lineView').on('click', function(){
        $('#gridView').children("i").removeClass('selected');
        $('#lineView').children("i").addClass('selected');
        $('.product').removeClass('displayGrid').addClass('displayLine').children(".productFooter").addClass('displayLineFooter');
        viewType = "displayLine";
    });

    // Hiding filters

    $('.hideToggle').on('click', function(){
        $(this).parent().parent().next().toggle();
        $(this).toggleClass('la-angle-up');
        $(this).toggleClass('la-angle-down');
    });

}

if (currentUrl.includes("/"))
{
    let sideMenuHidden = false;
    let userPanelToggle = false;
    let productsPanelToggle = false;
    let bannersPanelToggle = false;
    let messagesPanelToggle = false;
    deselectAllPanels();

    drawUsersPanel();
    drawProductsPanel();

    $('#sideMenuBtn').on('click', hideSideMenu);
    $('#userPanelToggle').on('click', function() {
        deselectAllPanels();
        userPanelToggle = !userPanelToggle;
        if (userPanelToggle)
            $(this).addClass('selectedOpt');
        else
            $(this).removeClass('selectedOpt');

        drawUsersPanel();
    });
    $('#productsPanelToggle').on('click', function() {
        deselectAllPanels();
        productsPanelToggle = !productsPanelToggle;
        if (productsPanelToggle)
            $(this).addClass('selectedOpt');
        else
            $(this).removeClass('selectedOpt');

        drawProductsPanel();
    });
    $('#bannersPanelToggle').on('click', function() {
        deselectAllPanels();
        bannersPanelToggle = !bannersPanelToggle;
        if (bannersPanelToggle)
            $(this).addClass('selectedOpt');
        else
            $(this).removeClass('selectedOpt');
    });
    $('#messagesPanelToggle').on('click', function() {
        deselectAllPanels();
        messagesPanelToggle = !messagesPanelToggle;
        if (messagesPanelToggle)
            $(this).addClass('selectedOpt');
        else
            $(this).removeClass('selectedOpt');
    });

    function hideSideMenu()
    {
        let sideMenuElement = document.getElementById("panelSideMenu");
        if (sideMenuHidden) {
            sideMenuElement.classList.remove("hideSideMenu");
        } else {
            sideMenuElement.classList.add("hideSideMenu");
        }
        sideMenuHidden = !sideMenuHidden;
    }

    function drawUsersPanel()
    {
        if (userPanelToggle)
            $('#usersConfigPanel').show();
        else
            $('#usersConfigPanel').hide();

        $('#productsConfigPanel').hide();
    }

    function drawProductsPanel()
    {
        if (productsPanelToggle)
            $('#productsConfigPanel').show();
        else
            $('#productsConfigPanel').hide();

        $('#usersConfigPanel').hide();
    }

    function deselectAllPanels()
    {
        $('.panelButton').removeClass('selectedOpt');
        userPanelToggle = false;
        productsPanelToggle = false;
        bannersPanelToggle = false;
        messagesPanelToggle = false;
    }


}