<?php

global $txt, $scripturl;

// Auto-embedder strings
$txt['aeva'] = 'Aeva';
//$txt['aeva_title'] = 'Aeva (Auto-Embed Video &amp; Audio)';
//$txt['aeva_admin_aeva'] = 'Administration Aeva - Param�tres';
//$txt['aeva_admin_aevasites'] = 'Administration Aeva - Liste des sites';
$txt['aeva_enable'] = 'Activer le mod Aeva (Outrepasse tout)';
$txt['aeva_lookups'] = 'Autoriser les lookups (v�rifications distantes)';
$txt['aeva_lookup_success'] = 'Votre serveur supporte les lookups.';
$txt['aeva_lookup_fail'] = 'Votre serveur ne supporte PAS les lookups.';
$txt['aeva_max_per_post'] = 'Nombre maximal d\'int�grations par message';
$txt['aeva_max_per_page'] = 'Nombre maximal d\'int�grations par page';
$txt['aeva_max_warning'] = 'Attention, l\'abus de Flash peut nuire � la sant� de votre navigateur !';
$txt['aeva_quotes'] = 'Autoriser l\'int�gration dans les citations (quotes)';
$txt['aeva_mov'] = '.MOV (via Quicktime)';
$txt['aeva_real'] = '.RAM/.RM (via Real Media)';
$txt['aeva_wmp'] = '.WMV/.WMA (via Windows Media)';
$txt['aeva_swf'] = '.SWF (Animations en Flash)';
$txt['aeva_flv'] = '.FLV (Vid�os en Flash)';
$txt['aeva_divx'] = '.DIVX (via lecteur DivX)';
$txt['aeva_avi'] = '.AVI (via lecteur DivX)';
$txt['aeva_mp3'] = '.MP3 (via lecteur Flash)';
$txt['aeva_mp4'] = '.MP4 (via lecteur Flash)';
$txt['aeva_ext'] = 'Extensions de fichier autoris�es';
$txt['aeva_fix_html'] = 'Corriger quand un lien HTML d\'int�gration (embed link) est utilis� � la place de l\'URL';
$txt['aeva_noexternalembedding'] = '(L\'auteur de la vid�o refuse les int�grations externes)';
$txt['aeva_includeurl'] = 'Inclure le lien d\'origine';
$txt['aeva_includeurl_desc'] = '(pour les sites qui ne l\'indiquent pas dans leur lecteur)';
$txt['aeva_debug'] = 'Mode d�bug Aeva (Admins uniquement)';
$txt['aeva_debug_took'] = 'D�bug Aeva:';
$txt['aeva_debug_seconds'] = ' secondes.';
$txt['aeva_debug_desc'] = 'Le temps pris pour g�n�rer l\'int�gration est ajout� dans chaque message.';
$txt['aeva_local'] = 'Int�grer les fichiers locaux (sauf fichiers joints)';
$txt['aeva_local_desc'] = 'Locaux signifie qu\'ils sont sur le m�me serveur. Mais cela n\'autorise pas pour autant l\'int�gration de n\'importe quel fichier de ce type n\'importe o�.';
$txt['aeva_denotes'] = '(Les sites annot�s d\'un * n�cessitent un lookup)';
$txt['aeva_fish'] = '(Les sites annot�s d\'un * n�cessitent un lookup, mais cette fonctionnalit� n\'est pas support�e par votre serveur.<br />� moins de rechercher l\'URL int�grable manuellement, vous ne pourrez pas int�grer de vid�os de ces sites.)';
$txt['aeva_pop_sites'] = 'Sites Populaires';
$txt['aeva_video_sites'] = 'Sites Vid�o';
$txt['aeva_audio_sites'] = 'Sites Audio';
$txt['aeva_other_sites'] = 'Autres Sites';
$txt['aeva_adult_sites'] = 'Sites pour Adultes';
$txt['aeva_custom_sites'] = 'Sites Personnels';
$txt['aeva_select'] = 'Tout s�lectionner';
$txt['aeva_reset'] = 'Remettre � z�ro';
$txt['aeva_disable'] = 'D�sactiver l\'int�gration';
$txt['aeva_sites'] = 'Liste des sites';
$txt['aeva_titles'] = 'Stocker et montrer les titres des vid�os';
$txt['aeva_titles_desc'] = '(si le site est support� par Aeva)';
$txt['aeva_titles_yes'] = 'Oui, stocker et montrer';
$txt['aeva_titles_yes2'] = 'Oui, mais suspendre le stockage';
$txt['aeva_titles_no'] = 'Non, mais continuer � stocker pour plus tard';
$txt['aeva_titles_no2'] = 'Non, ne rien montrer, ne rien stocker';
$txt['aeva_inlinetitles'] = 'Montrer les titres dans les vignettes';
$txt['aeva_inlinetitles_desc'] = '(pour les sites le proposant, comme YouTube et Vimeo)';
$txt['aeva_inlinetitles_yes'] = 'Oui';
$txt['aeva_inlinetitles_maybe'] = 'Seulement si le titre n\'est pas stock�';
$txt['aeva_inlinetitles_no'] = 'Non';
$txt['aeva_noscript'] = 'Utiliser l\'ancienne version d\'Aeva (sans Javascript)';
$txt['aeva_noscript_desc'] = 'Uniquement si vous avez des soucis de compatibilit�...';
$txt['aeva_expins'] = 'Utiliser la mise � jour express de Flash';
$txt['aeva_expins_desc'] = 'Si la version Flash de l\'utilisateur est p�rim�e, un utilitaire de mise � jour automatique s\'affichera';
$txt['aeva_lookups_desc'] = 'La plupart des fonctionnalit�s n�cessitent un lookup.';
$txt['aeva_center'] = 'Centrer toutes les vid�os horizontalement';
$txt['aeva_center_desc'] = 'Ou ajoutez "-center" aux options de la vid�o (exemple&nbsp;: #ws-hd-center)';
$txt['aeva_lookup_titles'] = 'Toujours essayer de chercher les titres';
$txt['aeva_lookup_titles_desc'] = '(m�me sur les sites non support�s, donc...)';
$txt['aeva_incontext'] = 'Autoriser l\'int�gration dans les phrases';
$txt['aeva_too_many_embeds'] = '(Int�gration d�sactiv�e, limite atteinte)';
$txt['aeva_nonlocal'] = 'Accepter les sites externes en plus des adresses internes';
$txt['aeva_nonlocal_desc'] = 'Au cas o� vous ne l\'auriez pas d�j� compris, c\'est fortement d�conseill�, du moins en mati�re de s�curit�.';
$txt['aeva_max_width'] = 'Largeur maximale pour les vid�os int�gr�es';
$txt['aeva_max_width_desc'] = 'Laissez vide pour d�sactiver. Entrez 600 pour une largeur maximale de 600 pixels. Les vid�os plus larges seront redimensionn�es, et celles plus petites afficheront un lien permettant de les �largir.';
$txt['aeva_yq'] = 'Qualit� YouTube par d�faut';
$txt['aeva_yq_default'] = 'D�faut';
$txt['aeva_yq_hd'] = 'HD si disponible';
$txt['aeva_small'] = 'Normal';
$txt['aeva_large'] = 'Large';

// General tabs and titles
$txt['aeva_title'] = 'Aeva Media';
$txt['aeva_admin'] = 'Admin';
$txt['aeva_add_title'] = 'Titre';
$txt['aeva_add_desc'] = 'Description';
$txt['aeva_add_file'] = 'Fichier � envoyer';
$txt['aeva_add_allowedTypes'] = 'Extensions autoris�es';
$txt['aeva_add_embed'] = '<i><u>Ou</u></i> URL de l\'�l�ment � int�grer';
$txt['aeva_add_keywords'] = 'Mots-cl�';
$txt['aeva_width'] = 'Largeur';
$txt['aeva_height'] = 'Hauteur';
$txt['aeva_albums'] = 'Albums';
$txt['aeva_icon'] = 'Ic�ne';
$txt['aeva_name'] = 'Nom';
$txt['aeva_item'] = '�l�ment';
$txt['aeva_items'] = '�l�ments';
$txt['aeva_lower_item'] = '�l�ment';
$txt['aeva_lower_items'] = '�l�ments';
$txt['aeva_files'] = 'Fichiers';
$txt['aeva_submissions'] = 'Soumissions';
$txt['aeva_started_on'] = 'D�marr�';
$txt['aeva_recent_items'] = 'Derniers ajouts';
$txt['aeva_random_items'] = '�l�ments au hasard';
$txt['aeva_recent_comments'] = 'Derniers commentaires';
$txt['aeva_recent_albums'] = 'Derniers albums';
$txt['aeva_views'] = 'Visites';
$txt['aeva_downloads'] = 'T�l�chargements';
$txt['aeva_posted_by'] = 'Par';
$txt['aeva_posted_on_date'] = 'Post� le';
$txt['aeva_posted_on'] = 'Post�';
$txt['aeva_in_album'] = 'dans';
$txt['aeva_comment_in'] = 'Dans';
$txt['aeva_on_date'] = 'le';
$txt['aeva_short_date_format'] = '%d %b %Y';
$txt['aeva_today'] = '<b>Aujourd\'hui</b>';
$txt['aeva_yesterday'] = '<b>Hier</b>';
$txt['aeva_by'] = 'par';
$txt['aeva_on'] = 'sur';
$txt['aeva_bytes'] = 'octets';
$txt['aeva_kb'] = 'Ko';
$txt['aeva_mb'] = 'Mo';
$txt['aeva_time'] = 'Heure';
$txt['aeva_date'] = 'Date';
$txt['aeva_unapproved_items'] = '�l�ments non approuv�s';
$txt['aeva_unapproved_comments'] = 'Commentaires non approuv�s';
$txt['aeva_unapproved_albums'] = 'Albums non approuv�s';
$txt['aeva_unapproved_item_edits'] = 'Modifications d\'�l�ments non approuv�es';
$txt['aeva_unapproved_album_edits'] = 'Modifications d\'albums non approuv�es';
$txt['aeva_reported_items'] = '�l�ments signal�s';
$txt['aeva_reported_comments'] = 'Commentaires signal�s';
$txt['aeva_submit'] = 'Soumettre';
$txt['aeva_sub_albums'] = 'Sous-Albums';
$txt['aeva_max_file_size'] = 'Taille maximale par fichier';
$txt['aeva_stats'] = 'Statistiques';
$txt['aeva_featured_album'] = 'Album Star';
$txt['aeva_album_type'] = 'Type d\'Album';
$txt['aeva_album_name'] = 'Nom de l\'Album';
$txt['aeva_album_desc'] = 'Description de l\'Album';
$txt['aeva_add_item'] = 'Ajouter un �l�ment';
$txt['aeva_sort_by'] = 'Trier par';
$txt['aeva_sort_by_0'] = 'ID';
$txt['aeva_sort_by_1'] = 'Date';
$txt['aeva_sort_by_2'] = 'Titre';
$txt['aeva_sort_by_3'] = 'Popularit�';
$txt['aeva_sort_by_4'] = 'Note';
$txt['aeva_sort_order'] = 'Ordre de tri';
$txt['aeva_sort_order_asc'] = 'Ascendant';
$txt['aeva_sort_order_desc'] = 'Descendant';
$txt['aeva_sort_order_filename'] = 'Nom des fichiers';
$txt['aeva_sort_order_filesize'] = 'Taille des fichiers';
$txt['aeva_sort_order_filedate'] = 'Date de cr�ation';
$txt['aeva_pages'] = 'Pages';
$txt['aeva_thumbnail'] = 'Miniature';
$txt['aeva_item_title'] = 'Titre';
$txt['aeva_item_desc'] = 'Description';
$txt['aeva_filesize'] = 'Taille du fichier';
$txt['aeva_keywords'] = 'Mots-cl�';
$txt['aeva_rating'] = 'Note';
$txt['aeva_rate_it'] = 'Noter&nbsp;!';
$txt['aeva_item_info'] = 'Informations';
$txt['aeva_comments'] = 'Messages';
$txt['aeva_comment'] = 'Commentaire';
$txt['aeva_sort_order_com'] = 'Commentaires tri�s par date';
$txt['aeva_comment_this_item'] = 'Commenter';
$txt['aeva_report_this_item'] = 'Signaler';
$txt['aeva_edit_this_item'] = 'Modifier';
$txt['aeva_delete_this_item'] = 'Effacer';
$txt['aeva_download_this_item'] = 'T�l�charger';
$txt['aeva_move_item'] = 'D�placer';
$txt['aeva_commenting_this_item'] = 'Commenter cet �l�ment';
$txt['aeva_reporting_this_item'] = 'Signaler cet �l�ment';
$txt['aeva_moving_this_item'] = 'D�placer cet �l�ment';
$txt['aeva_commenting'] = 'Commenter';
$txt['aeva_message'] = 'Message';
$txt['aeva_reporting'] = 'Signalement d\'un �l�ment';
$txt['aeva_reason'] = 'Raison';
$txt['aeva_add'] = 'Ajouter un �l�ment';
$txt['aeva_last_edited'] = 'Derni�re modification';
$txt['aeva_album'] = 'Album';
$txt['aeva_album_to_move'] = 'Album de destination';
$txt['aeva_moving'] = 'D�placement en cours';
$txt['aeva_viewing_unseen'] = '�l�ments non vus';
$txt['aeva_search_for'] = 'Chercher';
$txt['aeva_search_in_title'] = 'Chercher dans le titre';
$txt['aeva_search_in_description'] = 'Chercher dans la description';
$txt['aeva_search_in_kw'] = 'Chercher dans les mots-cl�';
$txt['aeva_search_in_album_name'] = 'Chercher dans les titres d\'album';
$txt['aeva_search_in_album'] = 'Chercher dans cet album';
$txt['aeva_search_in_all_albums'] = 'Tous les albums';
$txt['aeva_search_by_mem'] = 'Chercher dans les �l�ments de ce membre';
$txt['aeva_search_in_cf'] = 'Chercher dans %s';
$txt['aeva_search'] = 'Chercher';
$txt['aeva_owner'] = 'Propri�taire';
$txt['aeva_my_user_albums'] = 'Mes&nbsp;Albums';
$txt['aeva_yes'] = 'Oui';
$txt['aeva_no'] = 'Non';
$txt['aeva_extra_info'] = 'M�tadonn�es Exif';
$txt['aeva_poster_info'] = 'Contributeur';
$txt['aeva_gen_stats'] = 'Statistiques g�n�rales';
$txt['aeva_total_items'] = '�l�ments';
$txt['aeva_total_albums'] = 'Nombre d\'Albums';
$txt['aeva_total_comments'] = 'Commentaires';
$txt['aeva_total_featured_albums'] = 'Nombre d\'Albums Stars';
$txt['aeva_avg_items'] = '�l�ments par jour';
$txt['aeva_avg_comments'] = 'Commentaires par jour';
$txt['aeva_total_item_contributors'] = 'Nombre de Contributeurs';
$txt['aeva_total_commentators'] = 'Nombre de Commentateurs';
$txt['aeva_top_uploaders'] = 'Top 5 des Contributeurs';
$txt['aeva_top_commentators'] = 'Top 5 des Commentateurs';
$txt['aeva_top_albums_items'] = 'Top 5 des Albums par �l�ments';
$txt['aeva_top_albums_comments'] = 'Top 5 des Albums par commentaires';
$txt['aeva_top_items_views'] = 'Top 5 des �l�ments par popularit�';
$txt['aeva_top_items_comments'] = 'Top 5 des �l�ments par commentaires';
$txt['aeva_top_items_rating'] = 'Top 5 des �l�ments par note';
$txt['aeva_top_items_voters'] = 'Top 5 des �l�ments par votes';
$txt['aeva_filename'] = 'Nom du fichier';
$txt['aeva_aka'] = 'alias';
$txt['aeva_no_comments'] = 'Pas de commentaires';
$txt['aeva_no_items'] = 'Pas d\'�l�ments';
$txt['aeva_no_albums'] = 'Pas d\'albums';
$txt['aeva_no_uploaders'] = 'Pas de contributeurs';
$txt['aeva_no_commentators'] = 'Pas de commentateurs';
$txt['aeva_multi_upload'] = 'Envoi en Masse';
$txt['aeva_selectFiles'] = 'Choisir les fichiers';
$txt['aeva_upload'] = 'Publier';
$txt['aeva_errors'] = 'Erreurs';
$txt['aeva_membergroups_guests'] = 'Invit�s';
$txt['aeva_membergroups_members'] = 'Membres inscrits';
$txt['aeva_album_mainarea'] = 'Informations sur l\'album';
$txt['aeva_album_privacy'] = 'Confidentialit�';
$txt['aeva_all_albums'] = 'Tous les albums';
$txt['aeva_show'] = 'Montrer';
$txt['aeva_prev'] = 'Pr�c�dent';
$txt['aeva_next'] = 'Suivant';
$txt['aeva_embed_bbc'] = 'Lien en BBCode';
$txt['aeva_embed_html'] = 'Lien en HTML';
$txt['aeva_direct_link'] = 'Lien direct';
$txt['aeva_profile_sum_pt'] = 'Sommaire du profil Aeva Media';
$txt['aeva_profile_sum_desc'] = 'R�sum� des participations de l\'utilisateur � la galerie. Vous trouverez ici les statistiques et informations sur les messages et �l�ments envoy�s dans la galerie.';
$txt['aeva_profile_stats'] = 'Statistiques Aeva Media';
$txt['aeva_latest_item'] = 'Dernier �l�ment';
$txt['aeva_top_albums'] = 'Top des albums';
$txt['aeva_profile_viewitems'] = 'Aeva Media - Voir les �l�ments';
$txt['aeva_profile_viewcoms'] = 'Aeva Media - Voir les commentaires';
$txt['aeva_profile_viewvotes'] = 'Aeva Media - Voir les votes';
$txt['aeva_profile_viewitems_pt'] = '�l�ments publi�s';
$txt['aeva_profile_viewcoms_pt'] = 'Commentaires publi�s';
$txt['aeva_profile_viewvotes_pt'] = 'Votes publi�s';
$txt['aeva_profile_viewitems_desc'] = 'La liste des �l�ments post�s par l\'utilisateur, sauf ceux publi�s dans les albums auxquels vous n\'avez pas acc�s.';
$txt['aeva_profile_viewcoms_desc'] = 'La liste des commentaires post�s par l\'utilisateur, sauf ceux publi�s dans les albums auxquels vous n\'avez pas acc�s.';
$txt['aeva_profile_viewvotes_desc'] = 'La liste des notes donn�es par l\'utilisateur, sauf celles donn�es dans les albums auxquels vous n\'avez pas acc�s.';
$txt['aeva_version'] = 'Version install�e';
$txt['aeva_switch_fulledit'] = 'Passer en mode complet avec smileys et BBCode';
$txt['aeva_needs_js_flash'] = 'Veuillez noter que cette fonctionnalit� n�cessite le support de Javascript et de Flash par votre navigateur.';
$txt['aeva_action'] = 'Action';
$txt['aeva_member'] = 'Membre';
$txt['aeva_approve_this'] = 'Cet �l�ment est actuellement en attente d\'approbation.';
$txt['aeva_use_as_album_icon'] = 'Utiliser la vignette de cet �l�ment comme ic�ne de l\'album.';
$txt['aeva_default_sort_order'] = 'Ordre de tri par d�faut';
$txt['aeva_overall_prog'] = 'Avancement global';
$txt['aeva_curr_prog'] = 'Avancement du fichier en cours';
$txt['aeva_add_desc_subtxt'] = 'Vous pouvez utiliser du BBCode et raconter votre vie ici si vous le voulez. Mais on ne vous force pas, non plus.';
$txt['aeva_mark_as_seen'] = 'Marquer tout comme vu';
$txt['aeva_mark_album_as_seen'] = 'Marquer comme vu';
$txt['aeva_search_results_for'] = 'r�sultats pour la recherche sur';
$txt['aeva_toggle_all'] = 'Tout montrer/cacher';
$txt['aeva_weighted_mean'] = 'Moyenne pond�r�e';
$txt['aeva_passwd_locked'] = 'Album prot�g� par un mot de passe - Acc�s � d�bloquer';
$txt['aeva_passwd_unlocked'] = 'Album prot�g� par un mot de passe - Acc�s autoris�';
$txt['aeva_who_rated_what'] = 'Qui a vot� quoi ?';
$txt['aeva_max_thumbs_reached'] = '[Limite atteinte]';
$txt['aeva_filetype_im'] = 'Images';
$txt['aeva_filetype_au'] = 'Sons';
$txt['aeva_filetype_vi'] = 'Vid�os';
$txt['aeva_filetype_do'] = 'Documents';
$txt['aeva_filetype_zi'] = 'Archives multim�dia';
$txt['aeva_entities_always'] = 'Toujours convertir (recommand�)';
$txt['aeva_entities_no_utf'] = 'Toujours convertir, sauf en mode UTF-8';
$txt['aeva_entities_never'] = 'Ne jamais convertir';
$txt['aeva_prevnext_small'] = 'Montrer 3 vignettes dont l\'actuelle';
$txt['aeva_prevnext_big'] = 'Montrer 5 vignettes dont l\'actuelle';
$txt['aeva_prevnext_text'] = 'Montrer uniquement des liens texte';
$txt['aeva_prevnext_none'] = 'Ne rien montrer';
$txt['aeva_default_tag_normal'] = 'Montrer la vignette (petite taille)';
$txt['aeva_default_tag_preview'] = 'Montrer l\'aper�u (taille interm�diaire)';
$txt['aeva_default_tag_full'] = 'Montrer l\'image enti�re';
$txt['aeva_force_thumbnail'] = 'Utiliser ce fichier pour la vignette';
$txt['aeva_force_thumbnail_subtxt'] = 'Utile pour les fichiers locaux ne sachant pas g�n�rer leur propre vignette - une jaquette de CD pour un MP3, une copie d\'�cran pour une vid�o...';
$txt['aeva_force_thumbnail_edit'] = ' Laissez vide pour garder la vignette actuelle.';
$txt['aeva_default_perm_profile'] = 'Profil par d�faut';
$txt['aeva_perm_profile'] = 'Profil de permissions';
$txt['aeva_image'] = 'Image';
$txt['aeva_video'] = 'Vid�o';
$txt['aeva_audio'] = 'Audio';
$txt['aeva_doc'] = 'Document';
$txt['aeva_type_image'] = 'Image';
$txt['aeva_type_video'] = 'Vid�o';
$txt['aeva_type_audio'] = 'Fichier Audio';
$txt['aeva_type_embed'] = 'M�dia Externe';
$txt['aeva_type_doc'] = 'Document';
$txt['aeva_multi_download'] = 'T�l�charger en zip';
$txt['aeva_multi_download_desc'] = 'Ici vous pouvez t�l�charger plusieurs fichiers d\'un coup, compress�s au format zip. Choisissez les �l�ments � t�l�charger.';
$txt['aeva_album_is_hidden'] = 'Cet album n\'est navigable que par son cr�ateur (vous) et les administrateurs. Les groupes autoris�s pourront visionner les �l�ments si vous leur fournissez des liens directs vers ceux-ci.';
$txt['aeva_items_view'] = 'Mode d\'affichage';
$txt['aeva_view_normal'] = 'Vignettes';
$txt['aeva_view_filestack'] = 'Fichiers';
$txt['aeva_post_noun'] = 'message';
$txt['aeva_posts_noun'] = 'messages';
$txt['aeva_vote_noun'] = 'vote';
$txt['aeva_votes_noun'] = 'votes';
$txt['aeva_voter_list'] = 'Membres ayant vot� au moins une fois ';
$txt['aeva_pixels'] = 'pixels';
$txt['aeva_more_albums_left'] = 'et %d autres albums';
$txt['aeva_items_only_in_children'] = ' dans les sous-albums';
$txt['aeva_items_also_in_children'] = ', et %d dans les sous-albums';
$txt['aeva_unbrowsable'] = 'Navigation d�sactiv�e';
$txt['aeva_access_read'] = 'Lecture';
$txt['aeva_access_write'] = '�criture';
$txt['aeva_default_welcome'] = 'Bienvenue dans la galerie, propuls�e par Aeva Media. Pour supprimer ou modifier ce texte d\'introduction, modifiez le fichier /Themes/default/languages/Modifications.french.php et ajoutez-y la ligne :<br /><pre>$txt[\'aeva_welcome\'] = \'Bienvenue.\';</pre>Vous pouvez aussi modifier le texte directement dans la section administration, mais vous perdez la possibilit� de le traduire en plusieurs langues.';
$txt['aeva_mass_cancel'] = 'Annuler';
$txt['aeva_file_too_large_php'] = 'Ce fichier est trop gros pour le serveur. Il ne sera pas upload�, parce qu\'il bloquerait tout le processus. La taille maximale autoris�e par le serveur est de %s Mo.';
$txt['aeva_file_too_large_quota'] = 'Ce fichier est plus gros que votre quota ne l\'autorise. Il ne sera pas upload�.';
$txt['aeva_file_too_large_img'] = 'Ce fichier est plus gros que votre quota ne l\'autorise. Vous pouvez cliquer sur Annuler, ou essayer de l\'uploader quand m�me, car s\'agissant d\'une image, il sera peut-�tre redimensionn� avec succ�s vers une taille autoris�e.';
$txt['aeva_user_deleted'] = '(Compte supprim�)';
$txt['aeva_silent_update'] = 'Mise � jour discr�te';
$txt['aeva_close'] = 'Fermer';
$txt['aeva_page_seen'] = 'Marquer page comme vue';

// Aeva Media's Foxy! add-on strings
$txt['aeva_linked_topic'] = 'Sujet li�';
$txt['aeva_linked_topic_board'] = 'Cr�er un sujet li� dans...';
$txt['aeva_no_topic_board'] = 'Ne pas cr�er de sujet li�';
$txt['aeva_topic'] = 'Album&nbsp;';
$txt['aeva_tag_no_items'] = '(Pas d\'�l�ments � montrer)';
$txt['aeva_playlist'] = 'Playlist';
$txt['aeva_playlists'] = 'Playlists';
$txt['aeva_my_playlists'] = 'Mes Playlists';
$txt['aeva_related_playlists'] = 'Playlists associ�es ';
$txt['aeva_items_from_album'] = '%1$d �l�ments d\'un album';
$txt['aeva_items_from_albums'] = '%1$d �l�ments de %2$d albums';
$txt['aeva_from_album'] = 'd\'un album';
$txt['aeva_from_albums'] = 'de %1$d albums';
$txt['aeva_new_playlist'] = 'Nouvelle Playlist';
$txt['aeva_add_to_playlist'] = 'Ajouter � une playlist';
$txt['aeva_playlist_done'] = 'Op�ration ex�cut�e avec succ�s.';
$txt['aeva_and'] = 'et';
$txt['aeva_foxy_stats_video'] = 'vid�o';
$txt['aeva_foxy_stats_videos'] = 'vid�os';
$txt['aeva_foxy_stats_audio'] = 'fichier audio';
$txt['aeva_foxy_stats_audios'] = 'fichiers audio';
$txt['aeva_foxy_stats_image'] = 'image';
$txt['aeva_foxy_stats_images'] = 'images';
$txt['aeva_foxy_audio_list'] = 'Liste audio';
$txt['aeva_foxy_video_list'] = 'Liste de vid�os';
$txt['aeva_foxy_image_list'] = 'Liste d\'images';
$txt['aeva_foxy_media_list'] = 'Liste multim�dia';
$txt['aeva_foxy_add_tag'] = 'Cliquez <a href="%1$s">ici</a> pour ins�rer le tag dans votre message et fermer la fen�tre. (Exp�rimental !)';
$txt['aeva_foxy_and_children'] = 'et ses sous-albums';

// Lightbox strings
$txt['aeva_lightbox_section'] = 'Highslide (Transitions anim�es)';
$txt['aeva_lightbox_enable'] = 'Activer Highslide';
$txt['aeva_lightbox_enable_info'] = 'Highslide est un script utilis� pour afficher les images via une animation quand vous cliquez sur une vignette.';
$txt['aeva_lightbox_outline'] = 'Ombre port�e';
$txt['aeva_lightbox_outline_info'] = 'D�finit le type d\'ombre qui entourera le contenu agrandi. <i>drop-shadow</i> est une ombre port�e simple, tandis que <i>rounded-white</i> ajoute des bords blancs, des coins arrondis et une ombre port�e plus petite.';
$txt['aeva_lightbox_expand'] = 'Dur�e de l\'animation';
$txt['aeva_lightbox_expand_info'] = '<i>En millisecondes</i>. D�finit le temps pris par le zoom pour se r�aliser.';
$txt['aeva_lightbox_autosize'] = 'Adaptation � l\'�chelle';
$txt['aeva_lightbox_autosize_info'] = 'Permet aux images trop grandes d\'�tre r�duites pour ne pas d�passer la taille de la fen�tre du navigateur. Cliquez ensuite sur l\'ic�ne Agrandir pour les voir en taille normale.';
$txt['aeva_lightbox_fadeinout'] = 'Fondu encha�n�';
$txt['aeva_lightbox_fadeinout_info'] = 'Ajoute un effet de fondu encha�n� � l\'animation.';

// Highslide Javascript strings.
// Escape single quotes twice (\\\' instead of \') otherwise it won't work.
$txt['aeva_hs_close_title'] = 'Fermer (Echap)';
$txt['aeva_hs_move'] = 'D�placer';
$txt['aeva_hs_loading'] = 'Chargement...';
$txt['aeva_hs_clicktocancel'] = 'Cliquez pour annuler';
$txt['aeva_hs_clicktoclose'] = 'Cliquez pour fermer, glissez pour d�placer';
$txt['aeva_hs_expandtoactual'] = 'Afficher en taille r�elle (F)';
$txt['aeva_hs_focus'] = 'Cliquez pour mettre en avant';
$txt['aeva_hs_previous'] = 'Pr�c�dent (Fl�che gauche)';
$txt['aeva_hs_next'] = 'Suivante (Fl�che droite)';
$txt['aeva_hs_play'] = 'Diaporama (Espace)';
$txt['aeva_hs_pause'] = 'Pause Diaporama (Espace)';

// Help strings
$txt['aeva_add_keywords_sub'] = 'Utilisez des virgules pour s�parer les mots-cl�s. Si un mot-cl� contient une virgule, entourez-le de guillemets. Si votre mot-cl� contient des guillemets, oh et puis zut d�brouillez-vous.';
$txt['aeva_add_embed_sub'] = 'Adresse URL proposant la vid�o (sur YouTube ou autre). � n\'utiliser que si vous n\'uploadez pas de fichier.';
$txt['aeva_will_be_approved'] = 'Votre envoi devra �tre approuv� par un mod�rateur avant d\'�tre visible en ligne.';
$txt['aeva_com_will_be_approved'] = 'Votre commentaire devra �tre approuv� par un mod�rateur avant d\'�tre mis en ligne.';
$txt['aeva_album_will_be_approved'] = 'Votre album devra �tre approuv� par un mod�rateur avant d\'�tre mis en ligne.';
$txt['aeva_what_album'] = 'Cet �l�ment sera ajout� � l\'album <a href="%s">%s</a>';
$txt['aeva_what_album_select'] = 'Choisissez l\'album o� envoyer cet �l�ment&nbsp;';
$txt['aeva_no_listing'] = 'Pas d\'�l�ments � lister';
$txt['aeva_resized'] = 'Cliquez sur l\'image pour la voir en taille r�elle.';
// Escape single quotes twice (\\\' instead of \') for aeva_confirm, otherwise it won't work.
$txt['aeva_confirm'] = '�tes-vous s�r de vouloir faire cela ?';
$txt['aeva_reported'] = 'Cet �l�ment a �t� signal�, il sera prochainement pass� en revue par un mod�rateur.<br /><br /><a href="%s">Retour</a>';
$txt['aeva_edit_file_subtext'] = 'Laissez vide si vous ne souhaitez pas r�-envoyer le fichier et remplacer l\'ancien.';
$txt['aeva_embed_sub_edit'] = 'Si vous changez l\'adresse URL d\'int�gration, elle �crasera les URL ou fichiers pr�existants li�s � cet �l�ment';
$txt['aeva_editing_item'] = 'Vous �tes en train de modifier cet �l�ment&nbsp;: <a href="%s">%s</a>';
$txt['aeva_editing_com'] = 'Modification du commentaire';
$txt['aeva_moving_item'] = 'D�placement de l\'�l�ment';
$txt['aeva_search_by_mem_sub'] = 'Entrez les noms des membres en les s�parant par une virgule. Laissez vide pour chercher parmi les �l�ments de tous les membres.';
$txt['aeva_passwd_protected'] = 'Cet album est prot�g� par un mot de passe, merci de l\'entrer pour continuer.';
$txt['aeva_user_albums_desc'] = 'D\'ici vous pouvez g�rer vos albums, en ajouter ou les modifier.';
$txt['aeva_click_to_close'] = 'Cliquez pour fermer';
$txt['aeva_multi_dl_wait'] = 'Le script a �t� mis en pause pour �viter de surcharger le serveur. %s �l�ments termin�s sur %s.';
$txt['aeva_too_many_items'] = 'Trop d\'�l�ments, merci de restreindre votre choix.';

// Errors
$txt['aeva_albumSwitchError'] = 'Un ou plusieurs albums utilisent actuellement le profil que vous essayez de supprimer. Veuillez d\'abord choisir un profil vers lequel les transf�rer.';
$txt['aeva_accessDenied'] = 'D�sol�, mais vous n\'avez pas l\'autorisation d\'acc�der � la galerie';
$txt['aeva_add_not_allowed'] = 'D�sol�, mais vous n\'avez pas l\'autorisation d\'envoyer ce type d\'�l�ment dans cet album';
$txt['aeva_add_album_not_set'] = 'Pas d\'album sp�cifi�';
$txt['aeva_album_denied'] = 'L\'acc�s � cet album a �t� refus�';
$txt['aeva_file_not_specified'] = 'Vous n\'avez pas sp�cifi� de fichier � envoyer. Ou peut-�tre avez-vous essay� d\'envoyer un fichier trop imposant pour le serveur ?';
$txt['aeva_title_not_specified'] = 'Vous n\'avez pas sp�cifi� de titre';
$txt['aeva_invalid_extension'] = 'Le fichier n\'a pas une extension valide (%s)';
$txt['aeva_upload_file_too_big'] = 'La taille du fichier (% Ko) est sup�rieure � la taille autoris�e';
$txt['aeva_upload_dir_not_writable'] = 'Le dossier d\'upload n\'a pas les droits d\'�criture';
$txt['aeva_upload_failed'] = 'Une erreur s\'est produite pendant l\'envoi, merci de r�essayer ou de contacter l\'administrateur.<br />%s';
$txt['aeva_error_height'] = 'La hauteur de l\'image (%s pixels) est sup�rieure au maximum autoris�';
$txt['aeva_error_width'] = 'La largeur de l\'image (%s pixels) est sup�rieure au maximum autoris�';
$txt['aeva_invalid_embed_link'] = 'L\'adresse URL d\'int�gration n\'est pas correcte, ou provient d\'un site non support�. Si vous tentez d\'int�grer une image externe, v�rifiez que l\'add-on Foxy! pour Aeva Media est bien install�.';
$txt['aeva_banned_full'] = 'D�sol�, vous �tes banni de la galerie !';
$txt['aeva_banned_post'] = 'D�sol�, vous n\'avez plus l\'autorisation de publier des �l�ments !';
$txt['aeva_banned_comment_post'] = 'D�sol�, vous n\'avez plus l\'autorisation de commenter !';
$txt['aeva_item_not_found'] = 'L\'�l�ment sp�cifi� est introuvable';
$txt['aeva_item_access_denied'] = 'Vous n\'�tes pas autoris� � acc�der � cet �l�ment';
$txt['aeva_invalid_rating'] = 'La note est invalide';
$txt['aeva_rate_denied'] = 'Vous n\'�tes pas autoris� � voter pour des �l�ments';
$txt['aeva_re-rating_denied'] = 'Vous n\'avez pas l\'autorisation de changer votre vote';
$txt['aeva_comment_not_allowed'] = 'Vous n\'�tes pas autoris� � laisser des commentaires';
$txt['aeva_comment_left_empty'] = 'Vous n\'avez pas laiss� de commentaire';
$txt['aeva_com_report_denied'] = 'Vous n\'�tes pas autoris� � signaler des commentaires';
$txt['aeva_report_left_empty'] = 'Vous n\'avez pas donn� de raison';
$txt['aeva_item_report_denied'] = 'Vous n\'�tes pas autoris� � signaler des �l�ments';
$txt['aeva_edit_denied'] = 'Vous n\'�tes pas autoris� � modifier cet �l�ment';
$txt['aeva_com_not_found'] = 'Commentaire introuvable';
$txt['aeva_delete_denied'] = 'Vous n\'�tes pas autoris� � supprimer un �l�ment';
$txt['aeva_move_denied'] = 'Vous n\'�tes pas autoris� � d�placer un �l�ment';
$txt['aeva_invalid_album'] = 'Votre soumission a �t� effectu�e dans un album invalide';
$txt['aeva_filemove_failed'] = 'Un probl�me est apparu lors du d�placement des fichiers';
$txt['aeva_search_left_empty'] = 'Les mots-cl� de recherche ont �t� laiss�s vides';
$txt['aeva_no_search_option_selected'] = 'Aucun param�tre n\'a �t� sp�cifi� pour la recherche';
$txt['aeva_search_mem_not_found'] = 'Aucun membre ne correspond � votre requ�te';
$txt['aeva_search_denied'] = 'Vous n\'�tes pas autoris� � rechercher un �l�ment dans la galerie';
$txt['aeva_album_not_found'] = 'Album introuvable';
$txt['aeva_unseen_denied'] = 'Vous n\'�tes pas autoris� � voir les �l�ments non visit�s';
$txt['aeva_dest_failed'] = 'Impossible de trouver la bonne destination sur le serveur, merci de contacter l\'administrateur.';
$txt['aeva_not_a_dir'] = 'L\'administrateur n\'a pas correctement renseign� le r�pertoire de donn�es d\'Aeva Media. Si vous �tes admin, allez le corriger dans les param�tres. Sinon, envoyez-lui un message et moquez-vous de lui. Mais pas trop hein, faut rester cool quoi, y\'a pas mort d\'homme.';
$txt['aeva_size_mismatch'] = 'La taille de ce fichier a chang� depuis sa mise en ligne initiale. Demandez � l\'administrateur s\'il a renvoy� manuellement le fichier par FTP. Si oui, dites-lui de recommencer mais cette fois en mode <i>binaire</i>, pas <i>ASCII</i> ou <i>auto</i>...';

// Admin general strings
$txt['aeva_admin_labels_index'] = 'Accueil';
$txt['aeva_admin_labels_settings'] = 'Param�tres';
$txt['aeva_admin_labels_embed'] = 'Int�gration';
$txt['aeva_admin_labels_reports'] = 'Signalements';
$txt['aeva_admin_labels_submissions'] = 'Soumissions';
$txt['aeva_admin_labels_bans'] = 'Bannissements';
$txt['aeva_admin_labels_albums'] = 'Albums';
$txt['aeva_admin_labels_maintenance'] = 'Maintenance';
$txt['aeva_admin_labels_about'] = '� propos';
$txt['aeva_admin_labels_ftp'] = 'Import par FTP';
$txt['aeva_admin_labels_perms'] = 'Permissions';
$txt['aeva_admin_labels_quotas'] = 'Quotas';
$txt['aeva_admin_settings_config'] = 'Configuration';
$txt['aeva_admin_settings_title_main'] = 'R�glages principaux';
$txt['aeva_admin_settings_title_security'] = 'R�glages de s�curit�';
$txt['aeva_admin_settings_title_limits'] = 'Limites';
$txt['aeva_admin_settings_title_tag'] = 'Tag [smg] et int�gration';
$txt['aeva_admin_settings_title_misc'] = 'Divers';
$txt['aeva_admin_settings_welcome'] = 'Message d\'accueil';
$txt['aeva_admin_settings_welcome_subtext'] = 'Laissez vide pour utiliser $txt[\'aeva_welcome\'] dans le fichier Modifications.english.php (que vous pouvez traduire � votre guise), ou le message d\'accueil par d�faut.';
$txt['aeva_admin_settings_data_dir_path'] = 'Chemin vers le r�pertoire de donn�es';
$txt['aeva_admin_settings_data_dir_path_subtext'] = 'Chemin sur le serveur (exemple&nbsp;: /home/www/mgal_data)';
$txt['aeva_admin_settings_data_dir_url'] = 'Adresse du r�pertoire de donn�es';
$txt['aeva_admin_settings_data_dir_url_subtext'] = 'M�me chemin, mais accessible par le web (exemple&nbsp;: http://mysite.com/mgal_data)';
$txt['aeva_admin_settings_max_dir_files'] = 'Nombre maximal de fichiers par r�pertoire';
$txt['aeva_admin_settings_max_dir_size'] = 'Taille maximale d\'un r�pertoire';
$txt['aeva_admin_settings_enable_re-rating'] = 'Autoriser � changer son vote';
$txt['aeva_admin_settings_use_exif_date'] = 'Utiliser la date Exif si possible';
$txt['aeva_admin_settings_use_exif_date_subtext'] = 'Si le fichier contient des donn�es Exif, la date de publication affich�e sera celle donn�e par Exif au lieu de l\'heure actuelle.';
$txt['aeva_admin_settings_title_files'] = 'R�glages pour les fichiers';
$txt['aeva_admin_settings_title_previews'] = 'R�glages pour les pr�visualisations';
$txt['aeva_admin_settings_max_file_size'] = 'Taille maximale des fichiers';
$txt['aeva_admin_settings_max_file_size_subtext'] = 'Mettez � 0 et utilisez la section Quotas pour affiner.';
$txt['aeva_admin_settings_max_width'] = 'Largeur maximale';
$txt['aeva_admin_settings_max_height'] = 'Hauteur maximale';
$txt['aeva_admin_settings_allow_over_max'] = 'Autoriser le redimensionnement';
$txt['aeva_admin_settings_allow_over_max_subtext'] = 'Si l\'image envoy�e d�passe les dimensions autoris�es, le serveur tentera de la redimensionner � la taille maximale autoris�e. � �viter pour les serveurs surcharg�s. Choisissez &quot;Non&quot; pour rejeter l\'image.';
$txt['aeva_admin_settings_upload_security_check'] = 'Activer la s�curit� pendant l\'envoi de fichiers';
$txt['aeva_admin_settings_upload_security_check_subtext'] = 'Permet d\'emp�cher l\'envoi de fichiers malicieux, mais peut parfois rejeter des fichiers sains. Inutile de l\'activer, sauf si vous avez des utilisateurs d\'IE vraiment, mais vraiment idiots, et qui cherchent les ennuis.';
$txt['aeva_admin_settings_log_access_errors'] = 'Archiver les erreurs d\'acc�s';
$txt['aeva_admin_settings_log_access_errors_subtext'] = 'Si activ�, toutes les erreurs d\'acc�s refus� dans Aeva Media seront archiv�es dans le journal d\'erreurs.';
$txt['aeva_admin_settings_ftp_file'] = 'Chemin d\'acc�s du fichier Safe Mode';
$txt['aeva_admin_settings_ftp_file_subtext'] = 'Lisez le fichier MGallerySafeMode.php pour plus d\'informations. N�cessaire si votre serveur est en Safe Mode !';
$txt['aeva_admin_settings_jpeg_compression'] = 'Compression Jpeg';
$txt['aeva_admin_settings_jpeg_compression_subtext'] = 'Qualit� des images redimensionn�es (dont les aper�us et les vignettes), de 0 (fichiers l�gers, mauvaise qualit�) � 100 (gros fichiers, haute qualit�). La valeur par d�faut (80) est recommand�e. Restez entre 65 et 85.';
$txt['aeva_admin_settings_exif'] = 'Exif';
$txt['aeva_admin_settings_layout'] = 'Apparence';
$txt['aeva_admin_settings_show_extra_info'] = 'Montrer les donn�es Exif';
$txt['aeva_admin_settings_show_info'] = 'M�tadonn�es Exif � montrer';
$txt['aeva_admin_settings_show_info_subtext'] = 'Les images prises par des appareils num�riques renferment souvent des informations utiles, telles que l\'heure o� a �t� pris un clich�. Vous pouvez choisir de les montrer ou pas.';
$txt['aeva_admin_settings_num_items_per_page'] = 'Nombre d\'�l�ments par page';
$txt['aeva_admin_settings_max_thumbs_per_page'] = 'Tags [smg] max par page';
$txt['aeva_admin_settings_max_thumbs_per_page_subtext'] = 'Nombre maximal de tags [smg] autoris�s par page (ceux-ci sont transform�s en vignettes)';
$txt['aeva_admin_settings_recent_item_limit'] = 'Derniers �l�ments � montrer';
$txt['aeva_admin_settings_random_item_limit'] = '�l�ments au hasard � montrer';
$txt['aeva_admin_settings_recent_comments_limit'] = 'Derniers commentaires � montrer';
$txt['aeva_admin_settings_recent_albums_limit'] = 'Derniers albums � montrer';
$txt['aeva_admin_settings_max_thumb_width'] = 'Largeur maximale pour la vignette';
$txt['aeva_admin_settings_max_thumb_height'] = 'Hauteur maximale pour la vignette';
$txt['aeva_admin_settings_max_preview_width'] = 'Largeur maximale pour l\'aper�u';
$txt['aeva_admin_settings_max_preview_width_subtext'] = 'L\'aper�u est une image interm�diaire cliquable qui est montr�e sur la fiche consacr�e � l\'image en taille r�elle. Mettez � 0 pour d�sactiver sa g�n�ration. <b>Attention</b>, si les aper�us sont d�sactiv�s, les images de grande taille d�formeront peut-�tre l\'apparence de vos pages.';
$txt['aeva_admin_settings_max_preview_height'] = 'Hauteur maximale pour l\'aper�u';
$txt['aeva_admin_settings_max_preview_height_subtext'] = 'M�me chose. Si la largeur ou la hauteur est � 0, la g�n�ration d\'aper�us est d�sactiv�e.';
$txt['aeva_admin_settings_max_bigicon_width'] = 'Largeur maximale pour l\'ic�ne';
$txt['aeva_admin_settings_max_bigicon_width_subtext'] = 'Les ic�nes d\'album ont une vignette (dont la taille est la m�me que pour les vignettes d\'�l�ments), ainsi qu\'une ic�ne de taille arbitraire, montr�e uniquement sur les pages des albums. Vous pouvez r�gler ici la largeur maximale de cette ic�ne.';
$txt['aeva_admin_settings_max_bigicon_height'] = 'Hauteur maximale pour l\'ic�ne';
$txt['aeva_admin_settings_max_bigicon_height_subtext'] = 'M�me chose. Vous pouvez r�gler ici la hauteur maximale de cette ic�ne.';
$txt['aeva_admin_settings_max_title_length'] = 'Longueur maximale des titres';
$txt['aeva_admin_settings_max_title_length_subtext'] = 'Nombre maximal de caract�res � afficher pour les titres au-dessus des vignettes. Si coup�s, ils restent lisibles en passant la souris sur la vignette.';
$txt['aeva_admin_settings_enable_cache'] = 'Activer le cache';
$txt['aeva_admin_settings_image_handler'] = 'Gestionnaire d\'images';
$txt['aeva_admin_settings_show_sub_albums_on_index'] = 'Montrer les sous-albums dans l\'index';
$txt['aeva_admin_settings_use_lightbox'] = 'Utiliser Highslide (transitions anim�es)';
$txt['aeva_admin_settings_use_lightbox_subtext'] = 'Highslide est un module Javascript qui ajoute des ombres port�es aux images, ainsi que des transitions anim�es en cliquant sur les aper�us (zoom et fondu encha�n�). D�sactivez pour emp�cher l\'utilisation de HS sur tous les albums. Si activ�, les propri�taires d\'albums pourront tout de m�me d�sactiver Highslide sur leurs albums via leurs r�glages par album.';
$txt['aeva_admin_settings_album_edit_unapprove'] = 'N�cessiter une r�approbation apr�s modification sur un album';
$txt['aeva_admin_settings_item_edit_unapprove'] = 'N�cessiter une r�approbation apr�s modification sur un �l�ment';
$txt['aeva_admin_settings_show_linking_code'] = 'Afficher le code pour lier vers les images';
$txt['aeva_admin_settings_ffmpeg_installed'] = 'FFMPEG a �t� trouv� sur ce serveur, ses fonctions peuvent �tre utilis�es pour les fichiers vid�o. S\'il est activ�, il sera utilis� pour cr�er des vignettes et pour montrer des informations suppl�mentaires.';
$txt['aeva_admin_settings_entities_convert'] = 'Convertir les cha�nes UTF-8 en entit�s&nbsp;?';
$txt['aeva_admin_settings_entities_convert_subtext'] = 'Les cha�nes prendront un peu plus de place dans la base de donn�es, mais les textes seront toujours lisibles.';
$txt['aeva_admin_settings_prev_next'] = 'Montrer les �l�ments pr�c�dents et suivants&nbsp;?';
$txt['aeva_admin_settings_prev_next_subtext'] = 'Activez cette option pour montrer sur les pages d\'�l�ments des raccourcis (image ou texte) vers les �l�ments pr�c�dents et suivants.';
$txt['aeva_admin_settings_default_tag_type'] = 'Taille par d�faut dans les tags [smg]&nbsp;?';
$txt['aeva_admin_settings_default_tag_type_subtext'] = 'Choisissez le type d\'image � afficher par d�faut quand aucun type n\'est sp�cifi� pour les images affich�es via le tag [smg id=xxx type=xxx]';
$txt['aeva_admin_settings_num_items_per_line'] = 'Nombre d\'�l�ments par ligne';
$txt['aeva_admin_settings_num_items_per_line_ext'] = 'Nombre d\'�l�ments par ligne';
$txt['aeva_admin_settings_my_docs'] = 'Documents autoris�s';
$txt['aeva_admin_settings_my_docs_subtext'] = 'Vous pouvez choisir la liste des extensions autoris�es pour les Documents envoy�s. S�parez-les par des virgules (ex: "zip,pdf"). Si vous voulez remettre la liste � z�ro, voici les extensions support�es par d�faut&nbsp;: %s';
$txt['aeva_admin_settings_player_color'] = 'Couleur du lecteur audio/vid�o';
$txt['aeva_admin_settings_player_color_subtext'] = 'En code h�xa. Par d�faut, blanc (FFFFFF)';
$txt['aeva_admin_settings_player_bcolor'] = 'Couleur de fond du lecteur audio/vid�o';
$txt['aeva_admin_settings_player_bcolor_subtext'] = 'En code h�xa. Par d�faut, noir (000000)';
$txt['aeva_admin_settings_audio_player_width'] = 'Largeur du lecteur audio';
$txt['aeva_admin_settings_audio_player_width_subtext'] = 'En pixels. Par d�faut, 400';
$txt['aeva_admin_settings_phpini_subtext'] = 'Cette variable serveur limite la taille des envois, elle est configur�e via le fichier php.ini (voir documentation � droite)';
$txt['aeva_admin_settings_clear_thumbnames'] = 'Laisser en clair les adresses des vignettes';
$txt['aeva_admin_settings_clear_thumbnames_subtext'] = 'Si activ�, les vignettes seront li�es directement par leur URL. Gain de temps mais confidentialit� amoindrie.';
$txt['aeva_admin_settings_album_columns'] = 'Nombre de sous-albums par ligne';
$txt['aeva_admin_settings_album_columns_subtext'] = 'Par d�faut, 1. Si vous avez beaucoup de sous-albums, n\'h�sitez pas � mettre 2 ou 3 colonnes pour avoir plus d\'albums par ligne.';
$txt['aeva_admin_settings_icons_only'] = 'Utiliser les ic�nes comme raccourcis';
$txt['aeva_admin_settings_icons_only_subtext'] = 'Si cette option est activ�e, seules les ic�nes seront montr�es sous les vignettes des bo�tes d\'�l�ments, comme par exemple les listes d\'�l�ments sur les pages d\'albums. <i>Par</i>, <i>Visites</i>, etc. seront cach�s pour gagner en place.';

$txt['aeva_admin_add_album'] = 'Cr�er un Album';
$txt['aeva_admin_filter_normal_albums'] = 'Filtrer les albums normaux';
$txt['aeva_admin_filter_featured_albums'] = 'Filtrer les albums stars';
$txt['aeva_admin_moderation'] = 'Mod�ration';
$txt['aeva_admin_moving_album'] = 'D�placer un album';
$txt['aeva_admin_cancel_moving'] = 'Annuler le d�placement';
$txt['aeva_admin_type'] = 'Type';
$txt['aeva_admin_edit'] = 'Modifier';
$txt['aeva_admin_delete'] = 'Effacer';
$txt['aeva_admin_approve'] = 'Approuver';
$txt['aeva_admin_unapprove'] = 'D�sapprouver';
$txt['aeva_admin_before'] = 'Avant';
$txt['aeva_admin_after'] = 'Apr�s';
$txt['aeva_admin_child_of'] = 'Enfant de';
$txt['aeva_admin_target'] = 'Cible';
$txt['aeva_admin_position'] = 'Position';
$txt['aeva_admin_membergroups'] = 'Groupes de membres';
$txt['aeva_admin_membergroups_subtxt'] = 'Choisissez les groupes de membres qui seront autoris�s � acc�der � l\'album et � son contenu.<br />
<ul class="aevadesc">
	<li>Si les <strong>groupes primaires</strong> (indiqu�s en gras) sont coch�s, tous les membres du forum pourront acc�der � l\'album, il est donc inutile de cocher les autres groupes (sauf Invit�s).</li>
	<li>Acc�s en <strong>Lecture</strong> : le groupe peut consulter l\'album et ses �l�ments, et utiliser les �ventuelles permissions accord�es (commenter, noter, etc.)</li>
	<li>Acc�s en <strong>�criture</strong> : le groupe peut contribuer � l\'album en y envoyant des �l�ments.</li>
</ul>';
$txt['aeva_admin_membergroups_primary'] = 'Ce groupe est utilis� comme groupe primaire par un ou plusieurs membres.';
$txt['aeva_admin_passwd'] = 'Mot de passe';
$txt['aeva_admin_move'] = 'D�placer';
$txt['aeva_admin_total_submissions'] = 'Nombre de soumissions';
$txt['aeva_admin_maintenance_tasks'] = 'T�ches de maintenance';
$txt['aeva_admin_maintenance_utils'] = 'Utilitaires de maintenance';
$txt['aeva_admin_maintenance_regen'] = 'R�g�n�ration des vignettes et aper�us';
$txt['aeva_admin_maintenance_recount'] = 'Recompter les totaux';
$txt['aeva_admin_maintenance_recount_subtext'] = 'Recompte les totaux et les statistiques et les met � jour. Peut �tre utilis� pour r�parer des statistiques incorrectes.';
$txt['aeva_admin_maintenance_finderrors'] = 'Recherche d\'erreurs';
$txt['aeva_admin_maintenance_finderrors_subtext'] = 'Cherche les erreurs telles que fichier manquant (physique ou dans la base de donn�es), ou ID de dernier message ou d\'�l�ment incorrect.';
$txt['aeva_admin_maintenance_prune'] = 'Nettoyage';
$txt['aeva_admin_maintenance_prune_subtext'] = 'Utilitaire pour purger les commentaires/�l�ments avec des param�tres sp�cifiques';
$txt['aeva_admin_maintenance_browse'] = 'Parcourir les fichiers';
$txt['aeva_admin_maintenance_browse_subtext'] = 'Utilitaire pour parcourir les fichiers, montre aussi l\'utilisation d\'espace d\'un dossier/fichier';
$txt['aeva_maintenance_done'] = 'Maintenance effectu�e';
$txt['aeva_pruning'] = 'Nettoyage';
$txt['aeva_admin_maintenance_prune_days'] = ' jours au-del� desquels l\'�l�ment est consid�r� comme ancien';
$txt['aeva_admin_maintenance_prune_last_comment_age'] = 'Dernier commentaire plus vieux que';
$txt['aeva_admin_maintenance_prune_max_coms'] = 'Nombre de commentaires inf�rieur �';
$txt['aeva_admin_maintenance_prune_max_views'] = 'Nombre de visites inf�rieur �';
$txt['aeva_admin_maintenance_checkfiles'] = '�liminer les fichiers superflus';
$txt['aeva_admin_maintenance_checkfiles_subtext'] = 'Cherche les fichiers superflus (introuvables dans la table aeva_media), et offre la possibilit� de les supprimer.';
$txt['aeva_admin_maintenance_checkorphans'] = '�liminer les fichiers orphelins';
$txt['aeva_admin_maintenance_checkorphans_subtext'] = 'Cherche les fichiers orphelins (introuvables dans la table aeva_files), et offre la possibilit� de les supprimer. <strong>Attention !</strong> Si vous lancez cette op�ration, votre galerie sera <strong>inutilisable</strong> tant que ses trois phases ne seront pas termin�es. Le processus peut prendre beaucoup de temps sur une galerie cons�quente.';
$txt['aeva_admin_maintenance_regen_all'] = 'R�g�n�rer les vignettes et aper�us';
$txt['aeva_admin_maintenance_regen_embed'] = 'R�g�n�rer les vignettes des �l�ments int�gr�s';
$txt['aeva_admin_maintenance_regen_thumb'] = 'R�g�n�rer les vignettes';
$txt['aeva_admin_maintenance_regen_preview'] = 'R�g�n�rer les aper�us';
$txt['aeva_admin_maintenance_regen_all_subtext'] = 'Cette fonction supprimera et recr�era tous les aper�us et vignettes existants, mais seulement s\'ils peuvent �tre recr��s � partir de leur fichier source.';
$txt['aeva_admin_maintenance_regen_embed_subtext'] = 'Cette fonction supprimera et recr�era les vignettes, mais uniquement pour les <b>�l�ments int�gr�s</b> (YouTube ou autres).';
$txt['aeva_admin_maintenance_regen_thumb_subtext'] = 'Cette fonction supprimera et recr�era toutes les vignettes existantes, mais uniquement si elles peuvent �tre recr��es � partir du fichier source ou de l\'aper�u.';
$txt['aeva_admin_maintenance_regen_preview_subtext'] = 'Cette fonction supprimera et recr�era tous les aper�us existants, mais uniquement s\'ils peuvent �tre recr��s � partir du fichier source.';
$txt['aeva_admin_maintenance_operation_pending'] = 'L\'op�ration a �t� interrompue pour �viter de surcharger le serveur. Elle reprendra automatiquement dans une seconde. %s �l�ments termin�s sur %s.';
$txt['aeva_admin_maintenance_operation_pending_raw'] = 'L\'op�ration a �t� interrompue pour �viter de surcharger le serveur. Elle reprendra automatiquement dans une seconde.';
$txt['aeva_admin_maintenance_operation_phase'] = 'Phase %d/%d';
$txt['aeva_admin_maintenance_all_tasks'] = 'Toutes les t�ches';
$txt['aeva_admin_labels_modlog'] = 'Journal';
$txt['aeva_admin_action_type'] = 'Type d\'action';
$txt['aeva_admin_reported_item'] = '�l�ment signal�';
$txt['aeva_admin_reported_by'] = 'Signal� par';
$txt['aeva_admin_reported_on'] = 'Signal� le';
$txt['aeva_admin_del_report'] = 'Supprimer le rapport';
$txt['aeva_admin_del_report_item'] = 'Supprimer l\'�l�ment signal�';
$txt['aeva_admin_report_reason'] = 'Raison du signalement';
$txt['aeva_admin_banned'] = 'Banni';
$txt['aeva_admin_banned_on'] = 'Banni le';
$txt['aeva_admin_expires_on'] = 'Expire le';
$txt['aeva_never'] = 'Jamais';
$txt['aeva_admin_ban_type'] = 'Type de bannissement';
$txt['aeva_admin_ban_type_1'] = 'Complet';
$txt['aeva_admin_ban_type_2'] = 'Ajout d\'�l�ments';
$txt['aeva_admin_ban_type_3'] = 'Ajout de commentaires';
$txt['aeva_admin_ban_type_4'] = 'Ajout d\'�l�ments et de commentaires';
$txt['aeva_admin_banning'] = 'Bannissement d\'un membre';
$txt['aeva_admin_bans_add'] = 'Ajouter un bannissement';
$txt['aeva_unapproved_items_notice'] = 'Il y a %2$d �l�ment(s) non approuv�(s). <a href="%1$s">Cliquez ici pour les voir</a>.';
$txt['aeva_unapproved_coms_notice'] = 'Il y a %2$d commentaire(s) non approuv�(s). <a href="%1$s">Cliquez ici pour les voir</a>.';
$txt['aeva_unapproved_albums_notice'] = 'Il y a %2$d album(s) non approuv�(s). <a href="%1$s">Cliquez ici pour les voir</a>.';
$txt['aeva_reported_items_notice'] = '%2$d �l�ment(s) ont �t� signal�s. <a href="%1$s">Cliquez ici pour les voir</a>';
$txt['aeva_reported_comments_notice'] = '%2$d commentaire(s) ont �t� signal�s. <a href="%1$s">Cliquez ici pour les voir</a>';
$txt['aeva_admin_modlog_approval_item'] = 'Approuv� l\'�l�ment <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_ua_item'] = 'D�sapprouv� l\'�l�ment <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_item'] = 'Supprim� l\'�l�ment %s (�tait en attente d\'approbation)';
$txt['aeva_admin_modlog_approval_com'] = 'Approuv� le commentaire <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_com'] = 'Supprim� un commentaire de l\'�l�ment %s (�tait en attente d\'approbation)';
$txt['aeva_admin_modlog_approval_album'] = 'Approuv� l\'album <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_album'] = 'Supprim� l\'album %s (�tait en attente d\'approbation)';
$txt['aeva_admin_modlog_delete_item'] = 'Supprim� l\'�l�ment %s';
$txt['aeva_admin_modlog_delete_album'] = 'Supprim� l\'album %s';
$txt['aeva_admin_modlog_delete_comment'] = 'Supprim� un commentaire de l\'�l�ment %s';
$txt['aeva_admin_modlog_delete_report_item_report'] = 'Supprim� une plainte concernant l\'�l�ment #%s';
$txt['aeva_admin_modlog_delete_report_comment_report'] = 'Supprim� une plainte concernant le commentaire #%s';
$txt['aeva_admin_modlog_delete_item_item_report'] = 'Supprim� l\'�l�ment signal� #%s';
$txt['aeva_admin_modlog_delete_item_comment_report'] = 'Supprim� le commentaire signal� #%s';
$txt['aeva_admin_modlog_ban_add'] = 'Banni <a href="%s">%s</a>';
$txt['aeva_admin_modlog_ban_delete'] = 'D�banni <a href="%s">%s</a>';
$txt['aeva_admin_modlog_prune_item'] = 'Purg� %s �l�ment(s)';
$txt['aeva_admin_modlog_prune_comment'] = 'Purg� %s commentaire(s)';
$txt['aeva_admin_modlog_move'] = 'D�plac� <a href=%s">%s</a> de l\'album <a href="%s">%s</a> vers <a href="%s">%s</a>';
$txt['aeva_admin_modlog_qsearch'] = 'Recherche rapide par membre';
$txt['aeva_admin_modlog_filter'] = 'Journal de mod�ration filtr� par <a href="%s">%s</a>';
$txt['aeva_admin_view_image'] = 'Voir l\'image';
$txt['aeva_admin_live'] = 'En direct de SMF-Media.com';
$txt['aeva_admin_ftp_files'] = 'Fichiers dans le dossier FTP';
$txt['aeva_admin_profile_add'] = 'Cr�er un profil';
$txt['aeva_admin_prof_name'] = 'Nom du profil';
$txt['aeva_admin_create_prof'] = 'Cr�er le profil';
$txt['aeva_admin_members'] = 'Membres';
$txt['aeva_admin_prof_del_switch'] = 'Passer les albums � ce profil';
$txt['aeva_quota_profile'] = 'Profil de quotas';
$txt['aeva_album_hidden'] = 'D�sactiver la navigation';
$txt['aeva_album_hidden_subtxt'] = 'Activez cette option pour emp�cher la navigation dans l\'album � tout le monde sauf vous. Ses �l�ments RESTERONT visionnables aux groupes autoris�s. Utile pour faire un album dont les �l�ments ne doivent �tre publi�s que sur des messages de forum.';
$txt['aeva_allowed_members'] = 'Membres autoris�s (lecture)';
$txt['aeva_allowed_members_subtxt'] = 'Entrez la liste des membres, s�par�s par des virgules, dont vous souhaitez qu\'ils puissent consulter l\'album, m�me si leurs groupes n\'y sont pas autoris�s.';
$txt['aeva_allowed_write'] = 'Membres autoris�s (�criture)';
$txt['aeva_allowed_write_subtxt'] = 'Entrez la liste des membres, s�par�s par des virgules, dont vous souhaitez qu\'ils puissent envoyer des �l�ments dans l\'album, m�me si leurs groupes n\'y sont pas autoris�s.';
$txt['aeva_denied_members'] = 'Membres bannis (lecture)';
$txt['aeva_denied_members_subtxt'] = 'Entrez la liste des membres, s�par�s par des virgules, � qui vous souhaitez refuser de consulter l\'album, m�me si leurs groupes y sont autoris�s.';
$txt['aeva_denied_write'] = 'Membres bannis (�criture)';
$txt['aeva_denied_write_subtxt'] = 'Entrez la liste des membres, s�par�s par des virgules, � qui vous souhaitez refuser d\'envoyer des �l�ments dans l\'album, m�me si leurs groupes y sont autoris�s.';
$txt['aeva_admin_wselected'] = 'Avec la s�lection';
$txt['aeva_admin_apply_perm'] = 'Ajouter permission';
$txt['aeva_admin_clear_perm'] = 'Effacer permission';
$txt['aeva_admin_set_mg_perms'] = 'Utiliser les permissions de ce groupe';
$txt['aeva_admin_readme'] = 'Lisez-Moi';
$txt['aeva_admin_changelog'] = 'Changelog';

// Admin error strings
// Escape single quotes twice (\\\' instead of \') for aeva_admin_album_confirm, otherwise it won't work.
$txt['aeva_admin_album_confirm'] = '�tes-vous s�r de vouloir supprimer cet album ? Cela supprimera aussi les �l�ments et les commentaires inclus.';
$txt['aeva_admin_name_left_empty'] = 'Le nom n\'a pas �t� entr�';
$txt['aeva_admin_invalid_target'] = 'Cible sp�cifi�e invalide';
$txt['aeva_admin_invalid_position'] = 'Position sp�cifi�e invalide';
$txt['aeva_admin_prune_invalid_days'] = 'Donn�es &quot;jours&quot; non valides';
$txt['aeva_admin_no_albums'] = 'Pas d\'album sp�cifi�';
$txt['aeva_admin_rm_selected'] = 'Supprimer la s�lection';
$txt['aeva_admin_rm_all'] = 'Tout supprimer';
$txt['aeva_report_not_found'] = 'Signalement introuvable';
$txt['aeva_admin_bans_mems_empty'] = 'Aucun membre n\'a �t� sp�cifi�';
$txt['aeva_admin_bans_mems_not_found'] = 'Les membres sp�cifi�s sont introuvables';
$txt['aeva_ban_not_found'] = 'Bannissement introuvable';
$txt['aeva_admin_already_banned'] = 'Utilisateur d�j� banni';
$txt['aeva_admin_album_dir_failed'] = 'La cr�ation du r�pertoire de cet album a �chou�, assurez-vous que mgal_data/ et mgal_data/albums/ sont chmodd�s � 0777 ou 0755.';
$txt['aeva_admin_unique_permission'] = 'Vous devez ne s�lectionner qu\'une option';
$txt['aeva_admin_quick_none'] = 'Pas d\'option s�lectionn�e';
$txt['aeva_admin_invalid_groups'] = 'Une s�lection invalide a �t� d�tect�e. Peut-�tre le groupe s�lectionn� n\'existe-t-il pas. Si vous copiez des permissions, assurez-vous d\'avoir s�lectionn� au moins un groupe, et de ne pas y avoir mis le groupe dont vous copiez les permissions';

// Admin help strings
$txt['aeva_admin_desc'] = 'Administration Aeva Media';
$txt['aeva_admin_settings_desc'] = 'Vous �tes sur la page g�n�rale de configuration d\'Aeva Media.';
$txt['aeva_admin_embed_desc'] = 'Vous �tes sur la page de configuration de l\'int�gration automatique d\'Aeva Media. Vous pouvez y activer ou d�sactiver l\'int�gration des liens multim�dia provenant de sites tels que YouTube. Vous pouvez �galement consulter la liste des sites support�s, et les activer s�par�ment.';
$txt['aeva_admin_albums_desc'] = 'Vous �tes sur la page d\'administration des albums. Vous pouvez y g�rer l\'ajout, la suppression, la modification et le d�placement d\'albums. En cliquant sur le bouton <strong>+</strong>, vous obtiendrez plus d\'informations au sujet d\'un album.';
$txt['aeva_admin_subs_desc'] = 'Vous �tes sur la page d\'administration des soumissions, vous pouvez y voir/supprimer/approuver les �l�ments/commentaires/albums en attente d\'approbation.';
$txt['aeva_admin_maintenance_desc'] = 'Vous �tes sur la page de maintenance, vous y trouverez de nombreuses t�ches et fonctions utiles pour votre installation.';
$txt['aeva_admin_modlog_desc'] = 'Vous �tes sur la page du journal de mod�ration d\'Aeva Media, vous y trouverez les activit�s de mod�ration qui s\'y rapportent.';
$txt['aeva_admin_reports_desc'] = 'Vous �tes sur la page d\'administration des signalements. Vous pouvez y consulter/supprimer les �l�ments/commentaires signal�s par des utilisateurs, ou supprimer des rapports de signalement.';
$txt['aeva_admin_bans_desc'] = 'Vous �tes sur la page d\'administration des bannissements d\'Aeva Media. Vous pouvez y g�rer les utilisateurs bannis. Votre toute-puissance n\'a d\'�gale que votre cruaut�, ma�tre.';
$txt['aeva_admin_about_desc'] = 'Bienvenue dans la zone d\'administration d\'Aeva Media !';
$txt['aeva_admin_passwd_subtxt'] = 'Pour r�server l\'acc�s � cet album � ceux qui en ont le mot de passe. Sinon, laissez vide.';
$txt['aeva_admin_maintenance_finderror_pending'] = 'Ce script est toujours actif. %s �l�ments sur %s sont termin�s pour le moment.<br /><br /><a href="%s">Veuillez cliquer ici pour continuer</a>. Assurez-vous d\'avoir attendu 1 � 2 secondes afin d\'�viter les surcharges.';
$txt['aeva_admin_finderrors_1'] = 'Les erreurs suivantes ont �t� trouv�es par la recherche d\'erreurs';
$txt['aeva_admin_finderrors_missing_db_file'] = 'L\'entr�e de base de donn�es du fichier %s, utilis�e pour l\'�l�ment <a href="%s">%s</a>, est manquante.';
$txt['aeva_admin_finderrors_missing_db_thumb'] ='L\'entr�e de base de donn�es de la vignette %s, utilis�e pour l\'�l�ment <a href="%s">%s</a>, est manquante.';
$txt['aeva_admin_finderrors_missing_db_preview'] ='L\'entr�e de base de donn�es de l\'aper�u %s, utilis� pour l\'�l�ment <a href="%s">%s</a>, est manquante.';
$txt['aeva_admin_finderrors_missing_physical_file'] = 'Le fichier %s, utilis� par l\'�l�ment <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_physical_thumb'] = 'Le fichier de la vignette %s, associ�e � l\'�l�ment <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_physical_preview'] = 'Le fichier de l\'aper�u %s, associ� � l\'�l�ment <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_album'] = 'L\'album %s, associ� � l\'�l�ment <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_last_comment'] = 'Le commentaire %s, associ� � l\'�l�ment <a href="%s">%s</a> en tant que dernier commentaire, est manquant.';
$txt['aeva_admin_finderrors_parent_album_access'] = 'L\'album %s a �t� mis � jour pour retirer les groupes n\'ayant pas acc�s � son album parent.';
$txt['aeva_admin_finderrors_done'] = 'V�rification des erreurs termin�e. Aucune erreur trouv�e&nbsp;!';
$txt['aeva_admin_prune_done_items'] = 'Nettoyage des �l�ments termin�&nbsp;! %s �l�ment(s), %s commentaire(s) et %s fichier(s) supprim�(s)';
$txt['aeva_admin_prune_done_comments'] = 'Nettoyage des commentaires termin�&nbsp;! %s commentaire(s) supprim�(s)';
$txt['aeva_admin_maintenance_prune_item_help'] = 'Pour le nettoyage des �l�ments, vous pouvez supprimer les �l�ments qui ont plus de &quot;x&quot; jours, x pouvant �tre d�fini ci-dessous. Il y a quelques options suppl�mentaires <b>mais sont optionnelles</b>. Les albums peuvent �tre s�lectionn�s ensemble ou individuellement.';
$txt['aeva_admin_maintenance_prune_com_help'] = 'Pour le nettoyage des commentaires, vous pouvez nettoyer les commentaires qui ont plus de  &quot;x&quot; jours dans tous les albums, ou dans un album sp�cifi�.';
$txt['aeva_admin_maintenance_checkfiles_done'] = 'Les fichiers inutiles ont tous �t� supprim�s, pour un total de %s fichiers, lib�rant %s ko d\'espace disque.';
$txt['aeva_admin_maintenance_checkfiles_no_files'] = 'Pas de fichiers superflus trouv�s';
$txt['aeva_admin_maintenance_checkfiles_found'] = '%s fichier(s) superflu(s) trouv�(s), consommant %s ko d\'espace suppl�mentaire. <a href="%s">Cliquez ici</a> pour le(s) supprimer.';
$txt['aeva_admin_maintenance_checkorphans_done'] = 'Les fichiers orphelins suivants ont �t� supprim�s, pour un total de %s fichiers&nbsp;:';
$txt['aeva_admin_maintenance_checkorphans_no_files'] = 'Pas de fichiers orphelins trouv�s';
$txt['aeva_admin_maintenance_clear_pending'] = 'Ce script est toujours actif. %s �l�ments sur %s sont termin�s pour le moment.<br /><br /><a href="%s">Veuillez cliquer ici pour continuer</a>. Assurez-vous d\'avoir attendu 1 � 2 secondes afin d\'�viter les surcharges.';
$txt['aeva_admin_maintenance_clear_done'] = 'Tous les fichiers ont �t� renomm�s avec succ�s.';
$txt['aeva_admin_installed_on'] = 'Install� le';
$txt['aeva_admin_ffmpeg'] = ' FFMPEG';
$txt['aeva_admin_smf_ver'] = 'Version de SMF';
$txt['aeva_admin_php_ver'] = 'Version de PHP';
$txt['aeva_admin_about_header'] = 'Informations sur le serveur et ses modules install�s';
$txt['aeva_admin_credits_thanks'] = 'Ceux qui ont rendu Aeva Media possible&nbsp;!';
$txt['aeva_admin_credits'] = 'Cr�dits';
$txt['aeva_admin_thanks'] = 'Remerciements';
$txt['aeva_admin_about_modd'] = 'Mod�rateurs et g�rants du module';
$txt['aeva_admin_managers'] = 'G�rants';
$txt['aeva_admin_moderators'] = 'Mod�rateurs';
$txt['aeva_admin_icon_edit_subtext'] = 'Si vous d�sirez envoyer une ic�ne, l\'ancienne sera �cras�e. Laissez vide pour conserver l\'ancienne.';
$txt['aeva_admin_bans_mems_empty'] = 'Aucun membre n\'a �t� sp�cifi�';
$txt['aeva_admin_expires_on_help'] = 'Doit �tre indiqu� en &quot;jours&quot;, � partir de maintenant';
$txt['aeva_admin_modlog_desc'] = 'Le journal de mod�ration vous propose la liste de toutes les actions de mod�ration effectu�es sur la galerie. N\'oubliez pas qu\'une fois effac�es, les donn�es du journal ne sont plus r�cup�rables.';
$txt['aeva_admin_ftp_desc'] = 'Cette section vous permet d\'importer des �l�ments vers la galerie via un dossier distant sur le serveur. Cela permet notamment de mettre en place des fichiers plus gros que ne l\'autoriserait PHP pour un envoi classique.';
$txt['aeva_admin_ftp_help'] = 'Voici la liste des fichiers dans le dossier {Data_dir}/ftp. Merci de choisir l\'album de destination pour chaque dossier.';
$txt['aeva_admin_ftp_halted'] = 'Importation mise en pause pour �viter une surcharge serveur, %s import�s sur %s. Le processus va reprendre automatiquement.';
$txt['aeva_admin_perms_desc'] = 'Cette section vous permet de g�rer les diff�rents profils de permissions, destin�s � g�rer les autorisations sur les albums.';
$txt['aeva_admin_prof_del_switch_help'] = 'Si vous d�sirez supprimer un profil utilis� par un ou plusieurs albums, vous devrez attribuer un autre profil aux albums en question.';
$txt['aeva_admin_quotas_desc'] = 'D\'ici, vous pouvez g�rer les profils de quotas des groupes de membres. Oui, �a fait peur rien qu\'� le prononcer, �a.';
$txt['aeva_admin_safe_mode'] = 'Le Safe Mode de PHP est activ�. Il peut causer des conflits avec Aeva Media. Merci de le <span style="color: red">d�sactiver</span> ou de lire la documentation dans le fichier MGallerySafeMode.php !';
$txt['aeva_admin_safe_mode_none'] = 'Le Safe Mode de PHP est d�sactiv�, il ne devrait donc pas cr�er de conflit avec Aeva Media.';
$txt['aeva_admin_perms_warning'] = '<strong>Attention</strong>, les permissions g�n�rales d\'acc�s � Aeva Media sont � r�gler, groupe de membre par groupe de membre, dans <a href="%s">l\'administration classique</a>.';

// Exif strings
$txt['aeva_exif'] = 'Exif';
$txt['aeva_imagemagick'] = 'ImageMagick';
$txt['aeva_gd2'] = 'GD2';
$txt['aeva_MW'] = 'MagickWand';
$txt['aeva_imagick'] = 'IMagick';
$txt['aeva_exif_duration'] = 'Dur�e';
$txt['aeva_exif_bit_rate'] = 'D�bit';
$txt['aeva_exif_frame_count'] = 'Nombre d\'images';
$txt['aeva_exif_audio_codec'] = 'Codec audio';
$txt['aeva_exif_video_codec'] = 'Codec vid�o';
$txt['aeva_exif_copyright'] = 'Copyright';
$txt['aeva_exif_make'] = 'Marque';
$txt['aeva_exif_model'] = 'Mod�le';
$txt['aeva_exif_yres'] = 'R�solution-Y';
$txt['aeva_exif_xres'] = 'R�solution-X';
$txt['aeva_exif_resunit'] = 'Unit� de r�solution';
$txt['aeva_exif_datetime'] = 'Date';
$txt['aeva_exif_flash'] = 'Flash';
$txt['aeva_exif_focal_length'] = 'Longueur de focale';
$txt['aeva_exif_orientation'] = 'Orientation';
$txt['aeva_exif_xposuretime'] = 'Temps d\'exposition';
$txt['aeva_exif_not_available'] = 'Pas de donn�es';
$txt['aeva_exif_entries'] = 'Voir les donn�es';
$txt['aeva_exif_fnumber'] = 'Nombre F';
$txt['aeva_exif_iso'] = 'Valeur ISO';
$txt['aeva_exif_meteringMode'] = 'Mode de mesure';
$txt['aeva_exif_digitalZoom'] = 'Zoom num�rique';
$txt['aeva_exif_contrast'] = 'Contraste';
$txt['aeva_exif_sharpness'] = 'Piqu�';
$txt['aeva_exif_focusType'] = 'Type de focus';
$txt['aeva_exif_exifVersion'] = 'Version Exif';

// ModCP
$txt['aeva_modcp'] = 'Mod�ration';
$txt['aeva_modcp_desc'] = 'Le centre de mod�ration d\'Aeva Media vous permet de g�rer les soumissions et rapports envoy�s par les utilisateurs, et de consulter les journaux.';

// Per-album Permissions
$txt['permissionname_aeva_download_item'] = 'T�l�charger des �l�ments';
$txt['permissionname_aeva_add_videos'] = 'Ajouter des fichiers vid�o';
$txt['permissionname_aeva_add_audios'] = 'Ajouter des fichiers audio';
$txt['permissionname_aeva_add_docs'] = 'Ajouter des documents';
$txt['permissionname_aeva_add_embeds'] = 'Ajouter des fichiers int�gr�s';
$txt['permissionname_aeva_add_images'] = 'Ajouter des images';
$txt['permissionname_aeva_rate_items'] = 'Donner des notes aux �l�ments';
$txt['permissionname_aeva_edit_own_com'] = 'Modifier ses commentaires';
$txt['permissionname_aeva_report_com'] = 'Signaler des commentaires';
$txt['permissionname_aeva_edit_own_item'] = 'Modifier ses �l�ments';
$txt['permissionname_aeva_comment'] = 'Commenter des �l�ments';
$txt['permissionname_aeva_report_item'] = 'Signaler des �l�ments';
$txt['permissionname_aeva_auto_approve_com'] = 'Auto-approuver ses commentaires';
$txt['permissionname_aeva_auto_approve_item'] = 'Auto-approuver ses uploads';
$txt['permissionname_aeva_multi_upload'] = 'Envoyer des fichiers en masse';
$txt['permissionname_aeva_whoratedwhat'] = 'Voir qui a vot� quoi';
$txt['permissionname_aeva_multi_download'] = 'T�l�charger des albums zipp�s';

// Custom fields
$txt['aeva_cf_invalid'] = 'Valeur invalide pour %s';
$txt['aeva_cf_empty'] = 'Le champ %s a �t� laiss� vide';
$txt['aeva_cf_bbc'] = 'Ce champ peut utiliser du BBCode';
$txt['aeva_cf_required'] = 'Ce champ est requis';
$txt['aeva_cf_desc'] = 'D\'ici vous pouvez g�rer les champs personnels';
$txt['aeva_cf'] = 'Champs personnels';
$txt['aeva_admin_labels_fields'] = 'Champs personnels';
$txt['aeva_cf_name'] = 'Nom du champ';
$txt['aeva_cf_type'] = 'Type de champ';
$txt['aeva_cf_add'] = 'Cr�er un champ';
$txt['aeva_cf_req'] = 'Requis';
$txt['aeva_cf_searchable'] = 'Recherchable';
$txt['aeva_cf_bbcode'] = 'BBC';
$txt['aeva_cf_editing'] = 'Ajouter/modifier un champ personnel';
$txt['aeva_cf_text'] = 'Texte';
$txt['aeva_cf_radio'] = 'Boutons radio';
$txt['aeva_cf_checkbox'] = 'Cases � cocher';
$txt['aeva_cf_textbox'] = 'Champ texte';
$txt['aeva_cf_select'] = 'Liste d�roulante';
$txt['aeva_cf_options'] = 'Options du champ';
$txt['aeva_cf_options_stext'] = 'Ajouter des options pour les champs - valable uniquement pour les types Cases � cocher, Liste d�roulante ou Boutons radio. S�parez les choix par des virgules (,)';

// Who's online strings
$txt['aeva_wo_home'] = 'Consulte l\'<a href="' . $scripturl . '?action=media">accueil</a> de la galerie';
$txt['aeva_wo_admin'] = 'Administre la galerie';
$txt['aeva_wo_unseen'] = 'Consulte les �l�ments non visit�s dans la galerie';
$txt['aeva_wo_search'] = 'Fait une recherche dans la galerie';
$txt['aeva_wo_item'] = 'Consulte &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_album'] = 'Consulte l\'album &quot;<a href="'.$scripturl.'?action=media;sa=album;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_add'] = 'Ajoute un �l�ment � l\'album &quot;<a href="'.$scripturl.'?action=media;sa=album;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_edit'] = 'Modifie &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_comment'] = 'Commente &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_reporting'] = 'Signale &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_stats'] = 'Consulte les statistiques de la galerie';
$txt['aeva_wo_vua'] = 'Consulte le panneau de contr�le d\'un album dans la galerie';
$txt['aeva_wo_ua'] = 'Consulte l\'accueil d\'un album dans la galerie';
$txt['aeva_wo_unknown'] = 'Effectue une action inconnue dans la galerie';
$txt['aeva_wo_hidden'] = 'R�de quelque part dans la galerie, � un endroit insondable...';

// Help popup for the SMG tag...
$txt['aeva_smg_tag'] = '
	<h1>Le tag [smg] et autres joyeuset�s.</h1>
	Un exemple en situation :
	<br />
	<br /><b>[smg id=123 type=preview align=center width=400 caption="Hello, world!"]</b>
	<br />Ce code affichera dans vos messages une image de taille interm�diaire (aper�u), align�e au centre, redimensionn�e � 400 pixels de large, et accompagn�e d\'un texte descriptif.
	Tous les param�tres sont facultatifs, seul l\'identifiant de l\'�l�ment (id=123) est obligatoire.
	<br />
	<br /><b>[smg id=1 type=album]</b>
	<br />Ce code montrera une s�rie de vignettes de type box (voir plus bas) appartenant � l\'album num�ro 1, reproduisant plus ou moins le visuel de la page web de l\'album en question.
	<br /><br />
	<b>Valeurs possibles :</b>
	<br />- type=<i>normal, box, link, preview, full, album</i>
	<br />- align=<i>none, left, center, right</i>
	<br />- width=<i>123</i> (en pixels)
	<br />- caption=<i>&quot;Texte descriptif&quot;</i> ou caption=<i>EnUnMot</i>
	<br /><br />
	<b>id</b>
	<ul class="normallist">
		<li>Tous les �l�ments sont identifi�s par un num�ro d�di� que vous pouvez voir dans leur adresse. Indiquez-le ici. C\'est le seul param�tre obligatoire. Je sais, c\'est moche. C\'est la vie.
		Mais faites pas cette t�te, vous pouvez quand m�me sp�cifier plusieurs �l�ments en les s�parant par une virgule, comme dans "[smg id=1,2,3 type=album]".</li>
	</ul>
	<br />
	<b>type</b>
	<ul class="normallist">
		<li><b>normal</b> (d�faut, sauf si configur� diff�remment) - afficher la vignette. Cliquez dessus pour voir son aper�u.</li>
		<li><b>av</b> - afficher la vid�o ou le fichier audio dans le lecteur ad�quat. Si vous ne pr�cisez pas ce param�tre, la vignette habituelle sera affich�e, mais en cliquant dessus, c\'est le fichier complet qui sera charg�, brut. Pas classe, pas classe du tout.</li>
		<li><b>box</b> - afficher la vignette compl�te, avec tous ses d�tails, comme sur les pages galerie d\'Aeva Media. Cliquez sur la vignette pour aller vers la page consacr�e � l\'�l�ment.</li>
		<li><b>link</b> - afficher la vignette, mais le texte descriptif devient interactif. Cliquez dessus pour aller vers la page consacr�e � l\'�l�ment. Si le param�tre caption est vide, un texte par d�faut sera montr� � la place.</li>
		<li><b>preview</b> (peut �tre choisi par d�faut si configur�) - afficher l\'aper�u de l\'image (� mi-chemin entre la vignette et l\'image compl�te).</li>
		<li><b>full</b> (peut �tre choisi par d�faut si configur�) - afficher l\'image enti�re. N\'oubliez pas de r�gler le param�tre width !</li>
		<li><b>album</b> - afficher les derni�res vignettes de l\'album identifi� par son ID. Elles seront pr�sent�es sous la forme <b>box</b>.</li>
	</ul>
	<br />
	<b>align</b>
	<ul class="normallist">
		<li><b>none</b> (d�faut) - alignement normal. Les vignettes environnantes sont repouss�es � la ligne suivante ou pr�c�dente.</li>
		<li><b>left</b> - aligner la vignette � gauche. Utilisez plusieurs tags [smg] align�s ainsi pour montrer les vignettes c�te-�-c�te.</li>
		<li><b>center</b> - aligner la vignette au centre. Pour afficher une vignette � gauche, une au milieu et une � droite, ins�rez-les dans cet ordre : [smg align=left][smg align=right][smg align=center]</li>
		<li><b>right</b> - aligner la vignette � droite. M�me remarque que pour <i>left</i>. Rompez.</li>
	</ul>
	<br />
	<b>width</b>
	<ul class="normallist">
		<li>Utilisez ce param�tre pour forcer la largeur d\'une vignette � la dimension d�sir�e. Indiquez un nombre sup�rieur � z�ro.</li>
		<li>R�glez le param�tre <i>type</i> selon vos besoins. Ainsi, si vos vignettes ont pour largeur par d�faut 120 pixels, et vos aper�us 500 pixels, utilisez [smg type=preview] si vous forcez une largeur sup�rieure � 300 pixels, pour �viter un effet de flou trop visible.</li>
	</ul>
	<br />
	<b>caption</b>
	<ul class="normallist">
		<li>Affiche un texte descriptif sous la vignette. Si le type est d�fini � <i>link</i>, le texte sera cliquable et vous m�nera � la page consacr�e � l\'�l�ment.</li>
		<li>Entrez ce que vous voulez. Si votre texte contient des espaces ou des crochets, assurez-vous de l\'entourer de &quot;guillemets&quot;. Sinon, �a fait tout n\'importe quoi, et c\'est encore Bibi qui doit s\'y coller pour faire le m�nage.</li>
	</ul>';

$txt['aeva_permissions_help'] = 'D\'ici vous pouvez ajouter, modifier ou supprimer les profils de permissions. Les profils peuvent �tre assign�s � un ou plusieurs albums, et les albums en question suivront les permissions concern�es.';
$txt['aeva_permissions_undeletable'] = 'Vous ne pouvez pas supprimer ce profil, car c\'est un profil par d�faut.';

?>