function imprimirPedido() {
    var contenido = document.getElementById('pedido').outerHTML;
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Pedido de Sportseek</title>');
    printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
    printWindow.document.write('<style>');
    printWindow.document.write(`
        @media print {
            body {
                font-size: 14px;
            }
            .logo {
                width: 125px; /* Ajusta el tamaño del logo */
                height: auto;
            }
            .text-md-end {
                text-align: right !important;
            }
            .table {
                width: 100%;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid #000 !important;
            }
            .invoice-box {
                margin: 0 auto;
                padding: 20px;
                max-width: 800px;
                box-shadow: none !important;
            }
            .total-row {
                font-weight: bold;
            }
            /* Flexbox para alinear las dos columnas a la misma altura */
            .row.flex-container {
                display: flex;
                align-items: center;
            }
            .col-md-6 {
                flex: 1; /* Asegura que ambas columnas ocupen el mismo espacio */
            }
        }
    `);
    printWindow.document.write('</style></head><body>');
    printWindow.document.write(contenido);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
}

function descargarPDF() {
    var contenido = document.getElementById('pedido');
    html2canvas(contenido).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png');
        var doc = new jsPDF('p', 'mm', 'a4');
        var imgWidth = 210;
        var pageHeight = 295;
        var imgHeight = canvas.height * imgWidth / canvas.width;
        var heightLeft = imgHeight;
        var position = 0;

        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            doc.addPage();
            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }
        doc.save('pedido.pdf');
    });
}
