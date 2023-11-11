<?php
include_once("../../config.php");
$pagSeleccionada = "Deposito";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once($ESTRUCTURA . "/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $CSS ?>/estilos.css">
    <a href="../pagSegura/pagSegura.php">PagSegura</a>
    <?php include_once($ESTRUCTURA . "/cabeceraBD.php"); ?>
</head>

<body>
    <div class='container text-center p-4 mt-3 cajaLista col-4'>
        <h1>Gestion de Articulos</h1>
        <table id="dg" title="Productos" class="easyui-datagrid table m-auto" style="width:900px;height:250px" url="obtenerArticulos.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
            <thead class="table-dark fw-bold">
                <tr>
                    <th field="idProducto" width="50">#</th>
                    <th field="proNombre" width="50">Nombre</th>
                    <th field="proDetalle" width="50">Detalle</th>
                    <th field="imagen" width="50">imagen</th>
                    <th field="proCantStock" width="50">Cantidad Stock</th>
                </tr>
            </thead>
        </table>
        <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoArticulo()">Nuevo Articulo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarArticulo()">Editar Articulo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminarArticulo()">Eliminar Producto</a>
        </div>

        <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
            <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
                <h3>Informacion del Producto</h3>
                <div style="margin-bottom:10px">
                    <input name="proNombre" id="proNombre" class="easyui-textbox" required="true" label="Nombre del producto:" style="width:100%">
                </div>
                <div style="margin-bottom:10px">
                    <input name="proDetalle" id="proDetalle" class="easyui-textbox" required="true" label="Detalle:" style="width:100%">
                </div>
                <div style="margin-bottom:10px">
                    <input name="imagen" id="imagen" class="easyui-textbox" required="true" label="Ruta de imagen:" style="width:100%">
                </div>
                <div style="margin-bottom:10px">
                    <input name="proCantStock" id="proCantStock" class="easyui-textbox" required="true" validType="stock" label="Stock:" style="width:100%">
                </div>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="guardarArticulo()" style="width:90px">Guardar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
        </div>
    </div>
        <?php include_once($ESTRUCTURA . "/pie.php"); ?>
</body>

<script type="text/javascript">
    var url;

    function nuevoArticulo() {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New User');
        $('#fm').form('clear');
        url = 'nuevoArticulo.php';
    }

    function editarArticulo() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Menu');
            $('#fm').form('load', row);
            url = "editarArticulo.php?idProducto=" + row.idProducto;
        }
    }

    function guardarArticulo() {
        $('#fm').form('submit', {
            url: url,
            onSubmit: function() {
                return $(this).form('validate');
            },
            success: function(result) {
                console.log(result)
                try {
                    var resultObj = JSON.parse(result);
                    if (resultObj.errorMsg) {
                        $.messager.show({
                            title: 'Error',
                            msg: resultObj.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');
                        $('#dg').datagrid('reload');
                    }
                } catch (e) {
                    console.error('Error al analizar el resultado JSON: ', e);
                }
            }

        });
    }

    function eliminarArticulo() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('confirm', 'Are you sure you want to destroy this user?', function(r) {
                if (r) {
                    console.log(r);
                    $.post('eliminarArticulo.php?idProducto' + row.idProducto, {
                        idProducto: row.idProducto
                    }, function(result) {
                        console.log(result);
                        if (result.success) {
                            $('#dg').datagrid('reload'); // reload the user data
                        } else {
                            $.messager.show({ // show error message
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    }, 'json');
                }
            });
        }
    }
</script>
</body>

</html>

</html>