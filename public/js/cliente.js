url:'../../app/controllers/autcControllerCliente.php',
$(document).ready(function() {
    const selectCliente = $('#selectCliente');
    const datosCliente = $('#datosCliente');

    selectCliente.change(function() {
        const id = $(this).val();
        
        if (!id) {
            datosCliente.html('');
            return;
        }

        $.ajax({
            url: '?url=crear_informe',
            method: 'POST',
            dataType: 'json',
            data: { cliente_id: id },
            success: function(cliente) {
                renderizarDatosCliente(cliente);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener datos:', error);
                datosCliente.html('<p class="error">Error al cargar los datos</p>');
            }
        });
    });

    function renderizarDatosCliente(cliente) {
        datosCliente.html(`
            <h3>Datos del Cliente</h3>
            <p><strong>ID:</strong> ${cliente.id_cliente}</p>
            <p><strong>Nombre:</strong> ${cliente.cli_nombre}</p>
            <p><strong>Email:</strong> ${cliente.email}</p>
            <!-- Agrega más campos según necesites -->
        `);
    }
});

$(document).ready(function() {
    const selectCliente = $('#selectCliente');
    const tablaCliente = $('#tablaCliente');
    const tbodyDatos = $('#datosCliente');

    selectCliente.change(function() {
        const id = $(this).val();
        
        if (!id) {
            tablaCliente.hide();
            return;
        }

        $.ajax({
            url: '?url=obtener_cliente',
            method: 'POST',
            dataType: 'json',
            data: { cliente_id: id },
            success: function(cliente) {
                if (cliente) {
                    llenarTabla(cliente);
                    tablaCliente.show();
                } else {
                    tablaCliente.hide();
                }
            },
            error: function() {
                console.error('Error al cargar datos');
                tablaCliente.hide();
            }
        });
    });

    function llenarTabla(cliente) {
        const campos = {
            'Nombre': cliente.usu_nombre,
            'Apellido': cliente.usu_apellido,
            'Documento': cliente.usu_doc_identidad,
            'Teléfono': cliente.usu_telefono,
            'Email': cliente.usu_correo,
            'Dirección': cliente.direccion,
            'Ciudad': cliente.ciudad
            
        };

        let html = '';
        for (const [label, value] of Object.entries(campos)) {
            if (value) { 
                html += `
                    <tr>
                        <td width="30%"><strong>${label}</strong></td>
                        <td>${value}</td>
                    </tr>
                `;
            }
        }

        tbodyDatos.html(html);
    }
});