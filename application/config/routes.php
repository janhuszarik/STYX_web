<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
| my-controller/my-method	-> my_controller/my_method
*/

// Allgemeine Routen
$route['default_controller']                             = 'app';
$route['404_override']                                  = 'app/error404';
$route['translate_uri_dashes']                          = FALSE;
$route['generate_data']                                 = 'Generate_data/index';
$route['sitemap.xml']                                   = 'xml/sitemap';
$route['sitemap']                                       = 'xml/sitemap';

// Authentifizierungsrouten
$route['auth/login']                                    = 'auth/login';
$route['login']                                         = 'auth/login';
$route['auth/logout']                                   = 'auth/logout';
$route['logout']                                        = 'auth/logout';
$route['auth/delete_user/(:num)']                       = 'auth/delete_user/$1';
$route['auth/create_user']                              = 'auth/create_user';
$route['auth/activate']                                 = 'auth/activate';
$route['auth/forgot_password']                          = 'auth/forgot_password';
$route['auth/change_password']                          = 'auth/change_password';
$route['auth/edit_user/(:num)']                         = 'auth/edit_user/$1';
$route['admin/auth']                                    = 'auth';

// Frontend Routen
$route['article/view/(:num)']                           = 'app/routes';
$route['article/section/(:num)']                        = 'app/routes';
$route['news/category/(:num)']                          = 'app/routes';
$route['de/(:any)']                                     = 'app/routes/$1';
$route['besuchen/gruppenfuhrungen']                     = 'app/gruppenfuhrungen';
$route['app/send_gruppenfuhrung']                       = 'app/send_gruppenfuhrung';
$route['besuchen/betriebsfuehrungen']                   = 'app/betriebsfuhrungen';
$route['besuchen/kindergeburtstage/anfrage']            = 'app/kindergeburtstageAnfrage';
$route['app/send_kindergeburtstage']                    = 'app/send_kindergeburtstage';
$route['besuchen/shopfinder']                           = 'app/showMap';
$route['visit/shopfinder']                              = 'app/showMap';
$route['kontakt/send']                                  = 'app/send_contact';
$route['aktuelles/download-presse-login']               = 'app/download_presse_login';
$route['kontakt/kontakt-anfahrt']                       = 'app/kontakt';
$route['contact/contact-journey']                       = 'app/kontakt';
$route['app/test_mail']                                 = 'app/test_mail';

// Admin Routen - Allgemein
$route['admin']                                         = 'admin';
$route['admin/documentation']                           = 'admin/dokumentation';

// Admin Routen - Menü
$route['admin/menu']                                    = 'admin/menuSave';
$route['admin/menu/create']                             = 'admin/menuSave';
$route['admin/menu/edit/(:num)']                        = 'admin/menuSave/$1';
$route['admin/menu/del/(:num)']                         = 'admin/menuSave/del/$1';
$route['admin/menuSave']                                = 'admin/menuSave';

// Admin Routen - Artikelkategorien
$route['admin/article_categories']                      = 'article/articleCategoriesSave';
$route['admin/article_categories/(:num)']               = 'article/articleCategoriesSave/$1';
$route['admin/article_categories/del/(:num)']           = 'article/articleCategoriesSave/del/$1';
$route['admin/article_categories/edit/(:num)']          = 'article/articleCategoriesSave/edit/$1';
$route['admin/article_category_form']                   = 'article/articleCategoryForm';
$route['admin/article_category_form/(:num)']            = 'article/articleCategoryForm/$1';

// Admin Routen - Artikel
$route['admin/articles_in_category/(:num)/(:num)']      = 'article/articlesByCategory/$1/$2';
$route['admin/articles_in_category/(:num)']             = 'article/articlesByCategory/$1';
$route['admin/article_save']                            = 'article/articlesSave';
$route['admin/article_save/edit/(:num)']                = 'article/articlesSave/$1';
$route['admin/article_save/del/(:num)']                 = 'article/articlesSave/del/$1';
$route['admin/add_article/(:num)']                      = 'article/articlesSave/$1';
$route['admin/article/getGalleriesByCategory']          = 'article/getGalleriesByCategory';
$route['admin/article/upload_image']                    = 'article/upload_image';
$route['admin/article/getSubcategories']                = 'article/getSubcategories';
$route['admin/article/manageSubcategory']               = 'article/manageSubcategory';
$route['admin/article/deleteSubcategory']               = 'article/deleteSubcategory';
$route['admin/article/getSubcategoriesForManagement']   = 'article/getSubcategoriesForManagement';

// Admin Routen - Kalender
$route['admin/save_calendar_note']                      = 'admin/save_calendar_note';
$route['admin/update_calendar_note']                    = 'admin/update_calendar_note';
$route['admin/delete_calendar_note/(:num)']             = 'admin/delete_calendar_note/$1';

// Admin Routen - FTP Manager
$route['admin/ftpmanager']                              = 'ftpmanager/index';
$route['admin/ftpmanager/download']                     = 'ftpmanager/download';
$route['admin/ftpmanager/create_folder']                = 'ftpmanager/create_folder';
$route['admin/ftpmanager/move_file']                    = 'ftpmanager/move_file';
$route['admin/ftpmanager/delete']                       = 'ftpmanager/delete';
$route['admin/ftpmanager/upload']                       = 'ftpmanager/upload';
$route['admin/ftpmanager/modal']                        = 'ftpmanager/modal';
$route['admin/ftpmanager/browser']                      = 'ftpmanager/browser';
$route['admin/ftpmanager/load_folder']                  = 'ftpmanager/load_folder';

// Admin Routen - Slider
$route['admin/slider']                                  = 'admin/sliderSave';
$route['admin/slider/add']                              = 'admin/sliderSave';
$route['admin/slider/edit/(:num)']                      = 'admin/sliderSave';
$route['admin/slider/del/(:num)']                       = 'admin/sliderSave';
$route['admin/sliderSave']                              = 'admin/sliderSave';

// Admin Routen - News
$route['admin/news']                                    = 'admin/newsSave';
$route['admin/newsSave']                                = 'admin/newsSave';
$route['admin/news/add']                                = 'admin/newsSave';
$route['admin/news/edit/:num']                          = 'admin/newsSave';
$route['admin/news/del/:num']                           = 'admin/newsSave';

// Admin Routen - Bestes Produkt
$route['admin/bestProduct']                             = 'admin/bestProductSave';
$route['admin/bestProduct/create']                      = 'admin/bestProductSave/create';
$route['admin/bestProduct/edit/(:num)']                 = 'admin/bestProductSave/edit/$1';
$route['admin/bestProduct/del/(:num)']                  = 'admin/bestProductSave/del/$1';
$route['admin/bestProduct/save']                        = 'admin/bestProductSave';

// Admin Routen - Galerie
$route['admin/galleryCategory']                         = 'gallery/galleryCategorySave';
$route['admin/galleryCategory/edit/(:num)']             = 'gallery/galleryCategorySave/edit/$1';
$route['admin/galleryCategory/form']                    = 'gallery/galleryCategoryForm';
$route['admin/galleryCategory/form/(:num)']             = 'gallery/galleryCategoryForm/$1';
$route['admin/galleryCategory/save']                    = 'gallery/galleryCategorySave';
$route['admin/galleryCategory/delete/(:num)']           = 'gallery/deleteCategory/$1';
$route['admin/galleries_in_category/(:num)']            = 'gallery/galleriesInCategory/$1';
$route['admin/gallery/form/category/(:num)']            = 'gallery/galleryForm/$1';
$route['admin/gallery/save']                            = 'gallery/saveGallery';
$route['admin/gallery/edit/(:num)']                     = 'gallery/editGallery/$1';
$route['admin/gallery/delete/(:num)']                   = 'gallery/deleteGallery/$1';
$route['admin/image/form/gallery/(:num)']               = 'gallery/imageForm/$1';
$route['admin/image/save']                              = 'gallery/saveImage';
$route['admin/image/delete/(:num)']                     = 'gallery/deleteImage/$1';
$route['admin/image/update_order']                      = 'gallery/updateImageOrder';
$route['admin/uploadImage']                             = 'admin/uploadImage';

// Admin Routen - Shopfinder
$route['admin/shopfind']                                = 'shopfind/shopfindSave';
$route['admin/shopfind/(:any)']                         = 'shopfind/shopfindSave/$1';
$route['admin/shopfind/(:any)/(:num)']                  = 'shopfind/shopfindSave/$1/$2';


// Dynamische Routen
$route['(:any)/view/(:num)']                            = '$1/view/$2';
$route['view/(:any)/(:num)']                            = '$1/view/$2';
$route['(:any)/(:any)/(:any)/(:any)']                   = 'app/routes';
$route['(:any)/(:any)/(:any)']                          = 'app/routes';
$route['(:any)/(:any)']                                 = 'app/routes';
