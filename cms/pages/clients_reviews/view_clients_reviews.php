<script>
    jQuery(document).ready(function () {
        jQuery('body #clients_reviews')
                .addClass('active');
    });

    view_module('module_clients_reviews_table_json', 2000); // Универсальная
</script>

<div class="page-content-wrapper">
		<div class="page-content">
			<?php include_once $root.'/cms/pages/load_save_modal.php';  ?>
			
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Отзывы клиентов <small>Клиенты</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li class="btn-group">
							<button type="button" class="btn blue" onclick="location.href='admin.php?link=clients_reviews_edit_form&id=&sql_table=reviews&sql_images_table_name=reviews_images&sql_images_table_id_title=id_reviews&sql_features_table_name=none&sql_features_table_id_title=none';">
								<span>
									Добавить
								</span>
							</button>
						</li>
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo $admin_panel_link ?>">
								Панель управления
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="admin.php?link=clients_reviews">
								Отзывы клиентов
							</a>
						</li>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					

					<div class="portlet">
						
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover table-full-width" id="catalog_products_table">
							<thead>
							<tr>
								<th>
									ID
								</th>
                                                                <th>
									Изображение
								</th>
								<th class="width_200px">
									Клиент
								</th>
                                                                <th class="width_200px">
									Контакты
								</th>
                                                                <th>
									Дата отзыва
								</th>
								<th class="width_200px">
									Текст
								</th>
								<th>
									Комментарий 
								</th>
								<th>
									Опубликовано
								</th>
								<!--<th class="hidden-xs">
									Изображение
								</th> -->
								<th class="hidden-xs buttons_edit_delete">
									<!-- Кнопки редактирования -->
								</th>
							</tr>
							</thead>
							<tbody>
						
							</tbody>
							</table>
						</div>
					</div>
					
					
					
					
					
					
					
					
					
					
					
					
					
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	