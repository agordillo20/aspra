$(document).ready(function () {
    if ($('#carritoCentro').children().length > 0) {
        $('#finish').attr("disabled", false);
    }
});

function add(producto, cantidad) {
    if (existe(producto.cod_producto)) {
        sustituir(producto, parseInt(cantidad, 10));
    } else {
        añadir(producto, parseInt(cantidad, 10));
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
    var articulos = document.getElementById("carritoCentro");
    var mayor = false;
    var total = 0;
    var anterior_cantidad = 0;
    articulos.childNodes.forEach(function (item) {
        if (producto.cod_producto === item.lastChild.textContent && parseInt(item.childNodes[1].childNodes[0].textContent.split(' ')[1], 10) > 1) {
            anterior_cantidad = parseInt(item.childNodes[1].childNodes[0].textContent.split(' ')[1], 10) - 1;
            item.childNodes[1].childNodes[0].textContent = "x " + anterior_cantidad;
            item.childNodes[3].childNodes[0].textContent = (anterior_cantidad * producto.precio_venta) + "€";
            mayor = true;
        }
    });
    articulos.childNodes.forEach(function (item) {
        total += parseInt(item.childNodes[3].childNodes[0].textContent.slice(0, -1));
    });
    if (!mayor) {
        $('#column' + id).remove();
    }
    if (total === 0) {
        $('#finish').attr('disabled', true);
    }
    $('#precio').text("Total " + total + "€");
    var url = "/carrito/delete";
    $.ajax({
        type: 'post',
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {producto: producto, cantidad_actual: anterior_cantidad},
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

function añadir(producto, cantidad) {
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
    div2.appendChild(document.createTextNode("x " + cantidad));
    var div3 = document.createElement("div");
    div3.className = "col-5";
    div3.appendChild(document.createTextNode(producto.nombre));
    var div4 = document.createElement("div");
    div4.className = "col-1";
    div4.id = "precio" + id;
    div4.appendChild(document.createTextNode((producto.precio_venta * cantidad) + "€"));
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
    var nuevoTotal = anterior + (producto.precio_venta * cantidad);
    $('#precio').text("Total " + nuevoTotal + "€");
}

function sustituir(producto, cantidad) {
    var anterior = parseInt($('#precio').text().split(' ')[1].slice(0, -1), 10);
    var anterior_cantidad = 0;
    var nuevo_precio = 0;
    var articulos = document.getElementById("carritoCentro");
    var total = 0;
    articulos.childNodes.forEach(function (item) {
        if (producto.cod_producto === item.lastChild.textContent) {
            anterior_cantidad = parseInt(item.childNodes[1].childNodes[0].textContent.split(' ')[1], 10);
            anterior_cantidad += cantidad;
            item.childNodes[1].childNodes[0].textContent = "x " + anterior_cantidad;
            nuevo_precio = producto.precio_venta * anterior_cantidad;
            item.childNodes[3].childNodes[0].textContent = nuevo_precio + "€";
            total += nuevo_precio;
        }
    });
    $('#precio').text("Total " + total + "€");
}

function comprar() {
    var codigos = [];
    articulos.childNodes.forEach(function (item) {
        codigos.push(item.lastChild.textContent);
    });
}
