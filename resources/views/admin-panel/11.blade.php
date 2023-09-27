@extends('admin-panel.layouts.master')
@section('title','404')


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox mb-0">
                <div class="ibox-content">


                    <x-flash-message  
                        class="flash-danger"  
                        title="Form submit Error!" 
                        message=""  
                        message2=""  
                        :canClose="false" >
                        <x-slot name="insideContent">
                        	<ul>
                        		<li>One</li>
                        		<li>Two</li>
                        	</ul>
                        	<p>Course does not exist!</p>
                        </x-slot>
                    </x-flash-message>

                </div>
            </div>
        </div>
    </div>
@stop




<script>
    /*
	var readyForDraw = true;

	table=$('#bannerTable').DataTable({

		"ajax": 'http://local.sambole.com/banner/json/list',
		dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		buttons: [
			{extend: 'copy',className: 'btn-sm'},
			{extend: 'csv',title: 'Product Creation List', className: 'btn-sm'},
			{extend: 'pdf', title: 'Product Creation List', className: 'btn-sm'},
			{extend: 'print',className: 'btn-sm'}
		],
		"columnDefs": [
			{ "targets": [0,1,3,4,5,6], "searchable": false }
		],
		"autoWidth": false,
		rowReorder: {
			dataSrc: [[0]],
			update: false
		},
		"serverSide": true,
		// preDrawCallback: function () {
		//     return readyForDraw;
		// },
		fnDrawCallback:function (oSettings) {
			console.log("after table create");
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

			elems.forEach(function(html) {
				//need to check that it has not already be instantiated.
				if(!html.getAttribute('data-switchery')){
					var switchery = new Switchery(html, { size: 'small' });
				}
				html.onchange = function () {
					var checked = html.checked;
					var id = $(html).attr('bid');
					if (checked == false) {
						checked = 2;
					} else {
						checked = 1;
					}
					changeBannerState(id, checked);
				}
			});
		}
	});
    */
</script>
