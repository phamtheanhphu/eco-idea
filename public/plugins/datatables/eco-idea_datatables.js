/**
 * Created by phu.pham on 23/2/2018.
 */


EcoIdeaDataTables = {

    initStaticDataTable: function (tableId, isOnDestroy) {

        var dataTable = $('#' + tableId).DataTable({

            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],

            dom: 'Blfrtip',
            responsive: true,
            bDestroy: isOnDestroy,
            buttons: [
                {
                    extend: 'colvis',
                    //columns: ':not(.noVis)'
                    columns: ':gt(0)',
                }
            ],
            language: {
                paginate: {
                    previous: 'Trước',
                    next: 'Tiếp',
                },
                lengthMenu: 'Hiển thị _MENU_ dòng',
                previous: 'Trước',
                search: 'Tìm kiếm',
                processing: 'Đang tải dữ liệu...',
                zeroRecords: 'Không có dữ liệu được tìm thấy',
                infoEmpty: 'Không tồn tại',
                info: 'Hiển thị _PAGE_ trong tổng số _PAGES_ (trang)',
                buttons: {
                    colvis: 'Chọn cột hiện thị'
                }
            },
        });

        return dataTable;

    },
}