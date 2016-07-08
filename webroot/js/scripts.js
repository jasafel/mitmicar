$(document).ready(function() {      // Scripts que se ejecutan al cargar el documento 
    if (($('#region-id').length) && ($('#region-id').val() != 0)) {      // Si está el campo "comunidad" y tiene selección
        $.ajax({    
            type: "GET",
            url: "/tfg/provinces/get",
            data: { 'region_id': $('#region-id').val() },
            async: false,
            complete: function(result) {
                result = JSON.parse(result.responseText);
                provinceselected = document.getElementById("province-id").value;
                document.getElementById("province-id").innerHTML = null;
                document.getElementById("province-id").innerHTML += '<option value="0">(elige una provincia)</option>';
                $.each(result, function(index,element) {
                    document.getElementById("province-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                });
                if (provinceselected) {
                    document.getElementById("province-id").value = provinceselected;
                } else {
                    document.getElementById("province-id").value = 0;  
                }
            }
        });
    };
    if (($('#province-id').length) && ($('#province-id').val() != 0)) {    // Si está el campo "provincia" y tiene selección
        if ($('#municipality-id').length) {
            $.ajax({
                type: "GET",
                url: "/tfg/municipalities/get",
                data: { 'province_id': $('#province-id').val() },
                async: false,
                complete: function(result) {
                    result = JSON.parse(result.responseText);
                    municipalityselected = document.getElementById("municipality-id").value;
                    document.getElementById("municipality-id").innerHTML = null;
                    document.getElementById("municipality-id").innerHTML += '<option value="0">(elige un municipio)</option>';
                    $.each(result, function(index,element) {
                        document.getElementById("municipality-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                    });
                    if (municipalityselected) {
                        document.getElementById("municipality-id").value = municipalityselected;
                    } else {    // El municipio está sin seleccionar
                        document.getElementById("municipality-id").value = 0;   
                    }
                }
            });  
        };
        if ($('#mun-origin-id').length) {
            $.ajax({
                type: "GET",
                url: "/tfg/municipalities/get",
                data: { 'province_id': $('#province-id').val() },
                async: false,
                complete: function(result) {
                    result = JSON.parse(result.responseText);
                    municipalityselected = document.getElementById("mun-origin-id").value;
                    document.getElementById("mun-origin-id").innerHTML = null;
                    document.getElementById("mun-origin-id").innerHTML += '<option value="0">(elige un municipio)</option>';
                    $.each(result, function(index,element) {
                        document.getElementById("mun-origin-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                    });
                    document.getElementById("mun-origin-id").value = municipalityselected;
                }
            });  
        };
        if ($('#mun-destination-id').length) {
            $.ajax({
                type: "GET",
                url: "/tfg/municipalities/get",
                data: { 'province_id': $('#province-id').val() },
                async: false,
                complete: function(result) {
                    result = JSON.parse(result.responseText);
                    municipalityselected = document.getElementById("mun-destination-id").value;
                    document.getElementById("mun-destination-id").innerHTML = null;
                    document.getElementById("mun-destination-id").innerHTML += '<option value="0">(elige un municipio)</option>';
                    $.each(result, function(index,element) {
                        document.getElementById("mun-destination-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                    });
                    document.getElementById("mun-destination-id").value = municipalityselected;
                }
            });  
        };
    }    
    if (($('#model-id').length) && ($('#model-id').val() != 0)) {     // Si está el campo "marca" y tiene selección
        $.ajax({
            type: "GET",
            url: "/tfg/models/get",
            data: { 'make_id': $('#make-id').val() },
            async: false,
            complete: function(result) {
                result = JSON.parse(result.responseText);
                makeselected = document.getElementById("model-id").value;
                document.getElementById("model-id").innerHTML = null;
                document.getElementById("model-id").innerHTML += '<option value="0">(elige un modelo)</option>';
                $.each(result, function(index,element) {
                    document.getElementById("model-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                });
                document.getElementById("model-id").value = makeselected;
            }
        });
    };
    $('#region-id').change(function() {     // Script que se ejecuta al cambiar el campo "comunidad"
        $.ajax({
            type: "GET",
            url: "/tfg/provinces/get",
            data: { 'region_id': $(this).val() },
            async: false,
            complete: function(result) {
                result = JSON.parse(result.responseText);
                document.getElementById("province-id").innerHTML = null;
                document.getElementById("province-id").innerHTML += '<option value="0">(elige una provincia)</option>';
                $.each(result, function(index,element) {
                    document.getElementById("province-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                });
                document.getElementById("province-id").value = 0;   
                $('#province-id').change();     // Fuerza el reseteo del municipio
            }
        });
    });
    $('#province-id').change(function() {     // Script que se ejecuta al cambiar el campo "provincia"
        if ($('#municipality-id').length) {
            $.ajax({
                type: "GET",
                url: "/tfg/municipalities/get",
                data: { 'province_id': $(this).val() },
                async: false,
                complete: function(result) {
                    result = JSON.parse(result.responseText);
                    document.getElementById("municipality-id").innerHTML = null;
                    document.getElementById("municipality-id").innerHTML += '<option value="0">(elige un municipio)</option>';
                    $.each(result, function(index,element) {
                        document.getElementById("municipality-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                    });
                }
            });
        };
        if ($('#mun-origin-id').length) {
            $.ajax({
                type: "GET",
                url: "/tfg/municipalities/get",
                data: { 'province_id': $(this).val() },
                async: false,
                complete: function(result) {
                    result = JSON.parse(result.responseText);
                    document.getElementById("mun-origin-id").innerHTML = null;
                    document.getElementById("mun-origin-id").innerHTML += '<option value="0">(elige un municipio)</option>';
                    $.each(result, function(index,element) {
                        document.getElementById("mun-origin-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                    });
                }
            });
        }
        if ($('#mun-destination-id').length) {
            $.ajax({
                type: "GET",
                url: "/tfg/municipalities/get",
                data: { 'province_id': $(this).val() },
                async: false,
                complete: function(result) {
                    result = JSON.parse(result.responseText);
                    document.getElementById("mun-destination-id").innerHTML = null;
                    document.getElementById("mun-destination-id").innerHTML += '<option value="0">(elige un municipio)</option>';
                    $.each(result, function(index,element) {
                        document.getElementById("mun-destination-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                    });
                }
            });
        }
    });
    $('#make-id').change(function() {     // Script que se ejecuta al cambiar el campo "marca"
        $.ajax({
            type: "GET",
            url: "/tfg/models/get",
            data: { 'make_id': $(this).val() },
            async: false,
            complete: function(result) {
                result = JSON.parse(result.responseText);
                document.getElementById("model-id").innerHTML = null;
                document.getElementById("model-id").innerHTML += '<option value="0">(elige un modelo)</option>';
                $.each(result, function(index,element) {
                    document.getElementById("model-id").innerHTML += '<option value="'+ index +'">'+ element +'</option>';
                });
            }
        });
    });
});
