function add(producto) {
    var cantidad;
    if (existe(producto.cod_producto)) {
        cantidad = sustituir(producto);
    } else {
        añadir(producto);
        cantidad = 1;
    }
    var url = "/carrito/add";
    $.ajax({
        type: 'post',
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {producto: producto, cantidad: cantidad},
        error: function () {
            console.log("error en la peticion ajax");
        }
    });
}

function quitar(id, producto) {
    var precio = parseInt($('#precio' + id).text().slice(0, -1), 10);
    var total = parseInt($('#precio').text().split(' ')[1].slice(0, -1), 10);
    var cantidad = parseInt($('#cantidad' + id).text().split(' ')[1], 10);
    var nuevoTotal = total - (precio * cantidad);
    if (nuevoTotal === 0) {
        $('#finish').attr('disabled', true);
    }
    $('#precio').text("Total " + nuevoTotal + "€");
    $('#column' + id).remove();
    var url = "/carrito/delete";
    console.log(producto);
    $.ajax({
        type: 'post',
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {producto: producto},
        error: function () {
            console.log("error en la peticion ajax");
        }
    });
}

function existe(cod_producto) {
    var existe = false;
    var articulos = document.getElementById("carritoCentro");
    articulos.childNodes.forEach(function (item) {
        if (cod_producto === item.lastChild.textContent) {
            existe = true;
        }
    });
    return existe;
}

function añadir(producto) {
    var anterior = parseInt($('#precio').text().split(' ')[1].slice(0, -1), 10);
    $('#finish').attr("disabled", false);
    var id = uuid.v1();
    var div = document.createElement("div");
    div.className = "row pt-3 px-3";
    div.id = "column" + id;
    var div1 = document.createElement("div");
    div1.className = "col-1";
    var img = document.createElement("img");
    img.src = producto.foto;
    img.style.width = "30px";
    img.style.height = "30px";
    div1.appendChild(img);
    var div2 = document.createElement("div");
    div2.className = "col-2";
    div2.id = "cantidad" + id;
    div2.appendChild(document.createTextNode("x 1"));
    var div3 = document.createElement("div");
    div3.className = "col-5";
    div3.appendChild(document.createTextNode(producto.nombre));
    var div4 = document.createElement("div");
    div4.className = "col-1";
    div4.id = "precio" + id;
    div4.appendChild(document.createTextNode(producto.precio_venta + "€"));
    var div5 = document.createElement("div");
    div5.className = "col";
    var i = document.createElement("i");
    i.onclick = function () {
        quitar(this.id, producto);
    };
    i.id = id;
    i.className = "far fa-minus-square";
    div5.appendChild(i);
    var div6 = document.createElement("div");
    div6.appendChild(document.createTextNode(producto.cod_producto));
    div6.setAttribute("hidden", true);
    div.append(div1, div2, div3, div4, div5, div6);
    document.getElementById("carritoCentro").appendChild(div);
    var nuevoTotal = anterior + producto.precio_venta;
    $('#precio').text("Total " + nuevoTotal + "€");
}

function sustituir(producto) {
    var anterior = parseInt($('#precio').text().split(' ')[1].slice(0, -1), 10);
    var nueva_cantidad = 0;
    var nuevo_precio;
    var articulos = document.getElementById("carritoCentro");
    articulos.childNodes.forEach(function (item) {
        if (producto.cod_producto === item.lastChild.textContent) {
            nueva_cantidad = parseInt(item.childNodes[1].childNodes[0].textContent.split(' ')[1], 10) + 1;
            item.childNodes[1].childNodes[0].textContent = "x " + nueva_cantidad;
            nuevo_precio = parseInt(item.childNodes[3].childNodes[0].textContent.slice(0, -1), 10) + producto.precio_venta;
            item.childNodes[3].childNodes[0].textContent = nuevo_precio + "€";
        }
    });
    $('#precio').text("Total " + (anterior + producto.precio_venta) + "€");
    return nueva_cantidad;
}
