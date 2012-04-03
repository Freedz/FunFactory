<?php

global $txt, $scripturl;

// Auto-embedder strings
$txt['aeva'] = 'Aeva';
//$txt['aeva_title'] = 'Aeva (Auto-Embed Video &amp; Audio)';
//$txt['aeva_admin_aeva'] = 'Administration Aeva - Paramètres';
//$txt['aeva_admin_aevasites'] = 'Administration Aeva - Liste des sites';
$txt['aeva_enable'] = 'Activer le mod Aeva (Outrepasse tout)';
$txt['aeva_lookups'] = 'Autoriser les lookups (vérifications distantes)';
$txt['aeva_lookup_success'] = 'Votre serveur supporte les lookups.';
$txt['aeva_lookup_fail'] = 'Votre serveur ne supporte PAS les lookups.';
$txt['aeva_max_per_post'] = 'Nombre maximal d\'intégrations par message';
$txt['aeva_max_per_page'] = 'Nombre maximal d\'intégrations par page';
$txt['aeva_max_warning'] = 'Attention, l\'abus de Flash peut nuire à la santé de votre navigateur !';
$txt['aeva_quotes'] = 'Autoriser l\'intégration dans les citations (quotes)';
$txt['aeva_mov'] = '.MOV (via Quicktime)';
$txt['aeva_real'] = '.RAM/.RM (via Real Media)';
$txt['aeva_wmp'] = '.WMV/.WMA (via Windows Media)';
$txt['aeva_swf'] = '.SWF (Animations en Flash)';
$txt['aeva_flv'] = '.FLV (Vidéos en Flash)';
$txt['aeva_divx'] = '.DIVX (via lecteur DivX)';
$txt['aeva_avi'] = '.AVI (via lecteur DivX)';
$txt['aeva_mp3'] = '.MP3 (via lecteur Flash)';
$txt['aeva_mp4'] = '.MP4 (via lecteur Flash)';
$txt['aeva_ext'] = 'Extensions de fichier autorisées';
$txt['aeva_fix_html'] = 'Corriger quand un lien HTML d\'intégration (embed link) est utilisé à la place de l\'URL';
$txt['aeva_noexternalembedding'] = '(L\'auteur de la vidéo refuse les intégrations externes)';
$txt['aeva_includeurl'] = 'Inclure le lien d\'origine';
$txt['aeva_includeurl_desc'] = '(pour les sites qui ne l\'indiquent pas dans leur lecteur)';
$txt['aeva_debug'] = 'Mode débug Aeva (Admins uniquement)';
$txt['aeva_debug_took'] = 'Débug Aeva:';
$txt['aeva_debug_seconds'] = ' secondes.';
$txt['aeva_debug_desc'] = 'Le temps pris pour générer l\'intégration est ajouté dans chaque message.';
$txt['aeva_local'] = 'Intégrer les fichiers locaux (sauf fichiers joints)';
$txt['aeva_local_desc'] = 'Locaux signifie qu\'ils sont sur le même serveur. Mais cela n\'autorise pas pour autant l\'intégration de n\'importe quel fichier de ce type n\'importe où.';
$txt['aeva_denotes'] = '(Les sites annotés d\'un * nécessitent un lookup)';
$txt['aeva_fish'] = '(Les sites annotés d\'un * nécessitent un lookup, mais cette fonctionnalité n\'est pas supportée par votre serveur.<br />À moins de rechercher l\'URL intégrable manuellement, vous ne pourrez pas intégrer de vidéos de ces sites.)';
$txt['aeva_pop_sites'] = 'Sites Populaires';
$txt['aeva_video_sites'] = 'Sites Vidéo';
$txt['aeva_audio_sites'] = 'Sites Audio';
$txt['aeva_other_sites'] = 'Autres Sites';
$txt['aeva_adult_sites'] = 'Sites pour Adultes';
$txt['aeva_custom_sites'] = 'Sites Personnels';
$txt['aeva_select'] = 'Tout sélectionner';
$txt['aeva_reset'] = 'Remettre à zéro';
$txt['aeva_disable'] = 'Désactiver l\'intégration';
$txt['aeva_sites'] = 'Liste des sites';
$txt['aeva_titles'] = 'Stocker et montrer les titres des vidéos';
$txt['aeva_titles_desc'] = '(si le site est supporté par Aeva)';
$txt['aeva_titles_yes'] = 'Oui, stocker et montrer';
$txt['aeva_titles_yes2'] = 'Oui, mais suspendre le stockage';
$txt['aeva_titles_no'] = 'Non, mais continuer à stocker pour plus tard';
$txt['aeva_titles_no2'] = 'Non, ne rien montrer, ne rien stocker';
$txt['aeva_inlinetitles'] = 'Montrer les titres dans les vignettes';
$txt['aeva_inlinetitles_desc'] = '(pour les sites le proposant, comme YouTube et Vimeo)';
$txt['aeva_inlinetitles_yes'] = 'Oui';
$txt['aeva_inlinetitles_maybe'] = 'Seulement si le titre n\'est pas stocké';
$txt['aeva_inlinetitles_no'] = 'Non';
$txt['aeva_noscript'] = 'Utiliser l\'ancienne version d\'Aeva (sans Javascript)';
$txt['aeva_noscript_desc'] = 'Uniquement si vous avez des soucis de compatibilité...';
$txt['aeva_expins'] = 'Utiliser la mise à jour express de Flash';
$txt['aeva_expins_desc'] = 'Si la version Flash de l\'utilisateur est périmée, un utilitaire de mise à jour automatique s\'affichera';
$txt['aeva_lookups_desc'] = 'La plupart des fonctionnalités nécessitent un lookup.';
$txt['aeva_center'] = 'Centrer toutes les vidéos horizontalement';
$txt['aeva_center_desc'] = 'Ou ajoutez "-center" aux options de la vidéo (exemple&nbsp;: #ws-hd-center)';
$txt['aeva_lookup_titles'] = 'Toujours essayer de chercher les titres';
$txt['aeva_lookup_titles_desc'] = '(même sur les sites non supportés, donc...)';
$txt['aeva_incontext'] = 'Autoriser l\'intégration dans les phrases';
$txt['aeva_too_many_embeds'] = '(Intégration désactivée, limite atteinte)';
$txt['aeva_nonlocal'] = 'Accepter les sites externes en plus des adresses internes';
$txt['aeva_nonlocal_desc'] = 'Au cas où vous ne l\'auriez pas déjà compris, c\'est fortement déconseillé, du moins en matière de sécurité.';
$txt['aeva_max_width'] = 'Largeur maximale pour les vidéos intégrées';
$txt['aeva_max_width_desc'] = 'Laissez vide pour désactiver. Entrez 600 pour une largeur maximale de 600 pixels. Les vidéos plus larges seront redimensionnées, et celles plus petites afficheront un lien permettant de les élargir.';
$txt['aeva_yq'] = 'Qualité YouTube par défaut';
$txt['aeva_yq_default'] = 'Défaut';
$txt['aeva_yq_hd'] = 'HD si disponible';
$txt['aeva_small'] = 'Normal';
$txt['aeva_large'] = 'Large';

// General tabs and titles
$txt['aeva_title'] = 'Aeva Media';
$txt['aeva_admin'] = 'Admin';
$txt['aeva_add_title'] = 'Titre';
$txt['aeva_add_desc'] = 'Description';
$txt['aeva_add_file'] = 'Fichier à envoyer';
$txt['aeva_add_allowedTypes'] = 'Extensions autorisées';
$txt['aeva_add_embed'] = '<i><u>Ou</u></i> URL de l\'élément à intégrer';
$txt['aeva_add_keywords'] = 'Mots-clé';
$txt['aeva_width'] = 'Largeur';
$txt['aeva_height'] = 'Hauteur';
$txt['aeva_albums'] = 'Albums';
$txt['aeva_icon'] = 'Icône';
$txt['aeva_name'] = 'Nom';
$txt['aeva_item'] = 'Élément';
$txt['aeva_items'] = 'Éléments';
$txt['aeva_lower_item'] = 'élément';
$txt['aeva_lower_items'] = 'éléments';
$txt['aeva_files'] = 'Fichiers';
$txt['aeva_submissions'] = 'Soumissions';
$txt['aeva_started_on'] = 'Démarré';
$txt['aeva_recent_items'] = 'Derniers ajouts';
$txt['aeva_random_items'] = 'Éléments au hasard';
$txt['aeva_recent_comments'] = 'Derniers commentaires';
$txt['aeva_recent_albums'] = 'Derniers albums';
$txt['aeva_views'] = 'Visites';
$txt['aeva_downloads'] = 'Téléchargements';
$txt['aeva_posted_by'] = 'Par';
$txt['aeva_posted_on_date'] = 'Posté le';
$txt['aeva_posted_on'] = 'Posté';
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
$txt['aeva_unapproved_items'] = 'Éléments non approuvés';
$txt['aeva_unapproved_comments'] = 'Commentaires non approuvés';
$txt['aeva_unapproved_albums'] = 'Albums non approuvés';
$txt['aeva_unapproved_item_edits'] = 'Modifications d\'éléments non approuvées';
$txt['aeva_unapproved_album_edits'] = 'Modifications d\'albums non approuvées';
$txt['aeva_reported_items'] = 'Éléments signalés';
$txt['aeva_reported_comments'] = 'Commentaires signalés';
$txt['aeva_submit'] = 'Soumettre';
$txt['aeva_sub_albums'] = 'Sous-Albums';
$txt['aeva_max_file_size'] = 'Taille maximale par fichier';
$txt['aeva_stats'] = 'Statistiques';
$txt['aeva_featured_album'] = 'Album Star';
$txt['aeva_album_type'] = 'Type d\'Album';
$txt['aeva_album_name'] = 'Nom de l\'Album';
$txt['aeva_album_desc'] = 'Description de l\'Album';
$txt['aeva_add_item'] = 'Ajouter un élément';
$txt['aeva_sort_by'] = 'Trier par';
$txt['aeva_sort_by_0'] = 'ID';
$txt['aeva_sort_by_1'] = 'Date';
$txt['aeva_sort_by_2'] = 'Titre';
$txt['aeva_sort_by_3'] = 'Popularité';
$txt['aeva_sort_by_4'] = 'Note';
$txt['aeva_sort_order'] = 'Ordre de tri';
$txt['aeva_sort_order_asc'] = 'Ascendant';
$txt['aeva_sort_order_desc'] = 'Descendant';
$txt['aeva_sort_order_filename'] = 'Nom des fichiers';
$txt['aeva_sort_order_filesize'] = 'Taille des fichiers';
$txt['aeva_sort_order_filedate'] = 'Date de création';
$txt['aeva_pages'] = 'Pages';
$txt['aeva_thumbnail'] = 'Miniature';
$txt['aeva_item_title'] = 'Titre';
$txt['aeva_item_desc'] = 'Description';
$txt['aeva_filesize'] = 'Taille du fichier';
$txt['aeva_keywords'] = 'Mots-clé';
$txt['aeva_rating'] = 'Note';
$txt['aeva_rate_it'] = 'Noter&nbsp;!';
$txt['aeva_item_info'] = 'Informations';
$txt['aeva_comments'] = 'Messages';
$txt['aeva_comment'] = 'Commentaire';
$txt['aeva_sort_order_com'] = 'Commentaires triés par date';
$txt['aeva_comment_this_item'] = 'Commenter';
$txt['aeva_report_this_item'] = 'Signaler';
$txt['aeva_edit_this_item'] = 'Modifier';
$txt['aeva_delete_this_item'] = 'Effacer';
$txt['aeva_download_this_item'] = 'Télécharger';
$txt['aeva_move_item'] = 'Déplacer';
$txt['aeva_commenting_this_item'] = 'Commenter cet élément';
$txt['aeva_reporting_this_item'] = 'Signaler cet élément';
$txt['aeva_moving_this_item'] = 'Déplacer cet élément';
$txt['aeva_commenting'] = 'Commenter';
$txt['aeva_message'] = 'Message';
$txt['aeva_reporting'] = 'Signalement d\'un élément';
$txt['aeva_reason'] = 'Raison';
$txt['aeva_add'] = 'Ajouter un élément';
$txt['aeva_last_edited'] = 'Dernière modification';
$txt['aeva_album'] = 'Album';
$txt['aeva_album_to_move'] = 'Album de destination';
$txt['aeva_moving'] = 'Déplacement en cours';
$txt['aeva_viewing_unseen'] = 'Éléments non vus';
$txt['aeva_search_for'] = 'Chercher';
$txt['aeva_search_in_title'] = 'Chercher dans le titre';
$txt['aeva_search_in_description'] = 'Chercher dans la description';
$txt['aeva_search_in_kw'] = 'Chercher dans les mots-clé';
$txt['aeva_search_in_album_name'] = 'Chercher dans les titres d\'album';
$txt['aeva_search_in_album'] = 'Chercher dans cet album';
$txt['aeva_search_in_all_albums'] = 'Tous les albums';
$txt['aeva_search_by_mem'] = 'Chercher dans les éléments de ce membre';
$txt['aeva_search_in_cf'] = 'Chercher dans %s';
$txt['aeva_search'] = 'Chercher';
$txt['aeva_owner'] = 'Propriétaire';
$txt['aeva_my_user_albums'] = 'Mes&nbsp;Albums';
$txt['aeva_yes'] = 'Oui';
$txt['aeva_no'] = 'Non';
$txt['aeva_extra_info'] = 'Métadonnées Exif';
$txt['aeva_poster_info'] = 'Contributeur';
$txt['aeva_gen_stats'] = 'Statistiques générales';
$txt['aeva_total_items'] = 'Éléments';
$txt['aeva_total_albums'] = 'Nombre d\'Albums';
$txt['aeva_total_comments'] = 'Commentaires';
$txt['aeva_total_featured_albums'] = 'Nombre d\'Albums Stars';
$txt['aeva_avg_items'] = 'Éléments par jour';
$txt['aeva_avg_comments'] = 'Commentaires par jour';
$txt['aeva_total_item_contributors'] = 'Nombre de Contributeurs';
$txt['aeva_total_commentators'] = 'Nombre de Commentateurs';
$txt['aeva_top_uploaders'] = 'Top 5 des Contributeurs';
$txt['aeva_top_commentators'] = 'Top 5 des Commentateurs';
$txt['aeva_top_albums_items'] = 'Top 5 des Albums par éléments';
$txt['aeva_top_albums_comments'] = 'Top 5 des Albums par commentaires';
$txt['aeva_top_items_views'] = 'Top 5 des Éléments par popularité';
$txt['aeva_top_items_comments'] = 'Top 5 des Éléments par commentaires';
$txt['aeva_top_items_rating'] = 'Top 5 des Éléments par note';
$txt['aeva_top_items_voters'] = 'Top 5 des Éléments par votes';
$txt['aeva_filename'] = 'Nom du fichier';
$txt['aeva_aka'] = 'alias';
$txt['aeva_no_comments'] = 'Pas de commentaires';
$txt['aeva_no_items'] = 'Pas d\'éléments';
$txt['aeva_no_albums'] = 'Pas d\'albums';
$txt['aeva_no_uploaders'] = 'Pas de contributeurs';
$txt['aeva_no_commentators'] = 'Pas de commentateurs';
$txt['aeva_multi_upload'] = 'Envoi en Masse';
$txt['aeva_selectFiles'] = 'Choisir les fichiers';
$txt['aeva_upload'] = 'Publier';
$txt['aeva_errors'] = 'Erreurs';
$txt['aeva_membergroups_guests'] = 'Invités';
$txt['aeva_membergroups_members'] = 'Membres inscrits';
$txt['aeva_album_mainarea'] = 'Informations sur l\'album';
$txt['aeva_album_privacy'] = 'Confidentialité';
$txt['aeva_all_albums'] = 'Tous les albums';
$txt['aeva_show'] = 'Montrer';
$txt['aeva_prev'] = 'Précédent';
$txt['aeva_next'] = 'Suivant';
$txt['aeva_embed_bbc'] = 'Lien en BBCode';
$txt['aeva_embed_html'] = 'Lien en HTML';
$txt['aeva_direct_link'] = 'Lien direct';
$txt['aeva_profile_sum_pt'] = 'Sommaire du profil Aeva Media';
$txt['aeva_profile_sum_desc'] = 'Résumé des participations de l\'utilisateur à la galerie. Vous trouverez ici les statistiques et informations sur les messages et éléments envoyés dans la galerie.';
$txt['aeva_profile_stats'] = 'Statistiques Aeva Media';
$txt['aeva_latest_item'] = 'Dernier élément';
$txt['aeva_top_albums'] = 'Top des albums';
$txt['aeva_profile_viewitems'] = 'Aeva Media - Voir les éléments';
$txt['aeva_profile_viewcoms'] = 'Aeva Media - Voir les commentaires';
$txt['aeva_profile_viewvotes'] = 'Aeva Media - Voir les votes';
$txt['aeva_profile_viewitems_pt'] = 'Éléments publiés';
$txt['aeva_profile_viewcoms_pt'] = 'Commentaires publiés';
$txt['aeva_profile_viewvotes_pt'] = 'Votes publiés';
$txt['aeva_profile_viewitems_desc'] = 'La liste des éléments postés par l\'utilisateur, sauf ceux publiés dans les albums auxquels vous n\'avez pas accès.';
$txt['aeva_profile_viewcoms_desc'] = 'La liste des commentaires postés par l\'utilisateur, sauf ceux publiés dans les albums auxquels vous n\'avez pas accès.';
$txt['aeva_profile_viewvotes_desc'] = 'La liste des notes données par l\'utilisateur, sauf celles données dans les albums auxquels vous n\'avez pas accès.';
$txt['aeva_version'] = 'Version installée';
$txt['aeva_switch_fulledit'] = 'Passer en mode complet avec smileys et BBCode';
$txt['aeva_needs_js_flash'] = 'Veuillez noter que cette fonctionnalité nécessite le support de Javascript et de Flash par votre navigateur.';
$txt['aeva_action'] = 'Action';
$txt['aeva_member'] = 'Membre';
$txt['aeva_approve_this'] = 'Cet élément est actuellement en attente d\'approbation.';
$txt['aeva_use_as_album_icon'] = 'Utiliser la vignette de cet élément comme icône de l\'album.';
$txt['aeva_default_sort_order'] = 'Ordre de tri par défaut';
$txt['aeva_overall_prog'] = 'Avancement global';
$txt['aeva_curr_prog'] = 'Avancement du fichier en cours';
$txt['aeva_add_desc_subtxt'] = 'Vous pouvez utiliser du BBCode et raconter votre vie ici si vous le voulez. Mais on ne vous force pas, non plus.';
$txt['aeva_mark_as_seen'] = 'Marquer tout comme vu';
$txt['aeva_mark_album_as_seen'] = 'Marquer comme vu';
$txt['aeva_search_results_for'] = 'résultats pour la recherche sur';
$txt['aeva_toggle_all'] = 'Tout montrer/cacher';
$txt['aeva_weighted_mean'] = 'Moyenne pondérée';
$txt['aeva_passwd_locked'] = 'Album protégé par un mot de passe - Accès à débloquer';
$txt['aeva_passwd_unlocked'] = 'Album protégé par un mot de passe - Accès autorisé';
$txt['aeva_who_rated_what'] = 'Qui a voté quoi ?';
$txt['aeva_max_thumbs_reached'] = '[Limite atteinte]';
$txt['aeva_filetype_im'] = 'Images';
$txt['aeva_filetype_au'] = 'Sons';
$txt['aeva_filetype_vi'] = 'Vidéos';
$txt['aeva_filetype_do'] = 'Documents';
$txt['aeva_filetype_zi'] = 'Archives multimédia';
$txt['aeva_entities_always'] = 'Toujours convertir (recommandé)';
$txt['aeva_entities_no_utf'] = 'Toujours convertir, sauf en mode UTF-8';
$txt['aeva_entities_never'] = 'Ne jamais convertir';
$txt['aeva_prevnext_small'] = 'Montrer 3 vignettes dont l\'actuelle';
$txt['aeva_prevnext_big'] = 'Montrer 5 vignettes dont l\'actuelle';
$txt['aeva_prevnext_text'] = 'Montrer uniquement des liens texte';
$txt['aeva_prevnext_none'] = 'Ne rien montrer';
$txt['aeva_default_tag_normal'] = 'Montrer la vignette (petite taille)';
$txt['aeva_default_tag_preview'] = 'Montrer l\'aperçu (taille intermédiaire)';
$txt['aeva_default_tag_full'] = 'Montrer l\'image entière';
$txt['aeva_force_thumbnail'] = 'Utiliser ce fichier pour la vignette';
$txt['aeva_force_thumbnail_subtxt'] = 'Utile pour les fichiers locaux ne sachant pas générer leur propre vignette - une jaquette de CD pour un MP3, une copie d\'écran pour une vidéo...';
$txt['aeva_force_thumbnail_edit'] = ' Laissez vide pour garder la vignette actuelle.';
$txt['aeva_default_perm_profile'] = 'Profil par défaut';
$txt['aeva_perm_profile'] = 'Profil de permissions';
$txt['aeva_image'] = 'Image';
$txt['aeva_video'] = 'Vidéo';
$txt['aeva_audio'] = 'Audio';
$txt['aeva_doc'] = 'Document';
$txt['aeva_type_image'] = 'Image';
$txt['aeva_type_video'] = 'Vidéo';
$txt['aeva_type_audio'] = 'Fichier Audio';
$txt['aeva_type_embed'] = 'Média Externe';
$txt['aeva_type_doc'] = 'Document';
$txt['aeva_multi_download'] = 'Télécharger en zip';
$txt['aeva_multi_download_desc'] = 'Ici vous pouvez télécharger plusieurs fichiers d\'un coup, compressés au format zip. Choisissez les éléments à télécharger.';
$txt['aeva_album_is_hidden'] = 'Cet album n\'est navigable que par son créateur (vous) et les administrateurs. Les groupes autorisés pourront visionner les éléments si vous leur fournissez des liens directs vers ceux-ci.';
$txt['aeva_items_view'] = 'Mode d\'affichage';
$txt['aeva_view_normal'] = 'Vignettes';
$txt['aeva_view_filestack'] = 'Fichiers';
$txt['aeva_post_noun'] = 'message';
$txt['aeva_posts_noun'] = 'messages';
$txt['aeva_vote_noun'] = 'vote';
$txt['aeva_votes_noun'] = 'votes';
$txt['aeva_voter_list'] = 'Membres ayant voté au moins une fois ';
$txt['aeva_pixels'] = 'pixels';
$txt['aeva_more_albums_left'] = 'et %d autres albums';
$txt['aeva_items_only_in_children'] = ' dans les sous-albums';
$txt['aeva_items_also_in_children'] = ', et %d dans les sous-albums';
$txt['aeva_unbrowsable'] = 'Navigation désactivée';
$txt['aeva_access_read'] = 'Lecture';
$txt['aeva_access_write'] = 'Écriture';
$txt['aeva_default_welcome'] = 'Bienvenue dans la galerie, propulsée par Aeva Media. Pour supprimer ou modifier ce texte d\'introduction, modifiez le fichier /Themes/default/languages/Modifications.french.php et ajoutez-y la ligne :<br /><pre>$txt[\'aeva_welcome\'] = \'Bienvenue.\';</pre>Vous pouvez aussi modifier le texte directement dans la section administration, mais vous perdez la possibilité de le traduire en plusieurs langues.';
$txt['aeva_mass_cancel'] = 'Annuler';
$txt['aeva_file_too_large_php'] = 'Ce fichier est trop gros pour le serveur. Il ne sera pas uploadé, parce qu\'il bloquerait tout le processus. La taille maximale autorisée par le serveur est de %s Mo.';
$txt['aeva_file_too_large_quota'] = 'Ce fichier est plus gros que votre quota ne l\'autorise. Il ne sera pas uploadé.';
$txt['aeva_file_too_large_img'] = 'Ce fichier est plus gros que votre quota ne l\'autorise. Vous pouvez cliquer sur Annuler, ou essayer de l\'uploader quand même, car s\'agissant d\'une image, il sera peut-être redimensionné avec succès vers une taille autorisée.';
$txt['aeva_user_deleted'] = '(Compte supprimé)';
$txt['aeva_silent_update'] = 'Mise à jour discrète';
$txt['aeva_close'] = 'Fermer';
$txt['aeva_page_seen'] = 'Marquer page comme vue';

// Aeva Media's Foxy! add-on strings
$txt['aeva_linked_topic'] = 'Sujet lié';
$txt['aeva_linked_topic_board'] = 'Créer un sujet lié dans...';
$txt['aeva_no_topic_board'] = 'Ne pas créer de sujet lié';
$txt['aeva_topic'] = 'Album&nbsp;';
$txt['aeva_tag_no_items'] = '(Pas d\'éléments à montrer)';
$txt['aeva_playlist'] = 'Playlist';
$txt['aeva_playlists'] = 'Playlists';
$txt['aeva_my_playlists'] = 'Mes Playlists';
$txt['aeva_related_playlists'] = 'Playlists associées ';
$txt['aeva_items_from_album'] = '%1$d éléments d\'un album';
$txt['aeva_items_from_albums'] = '%1$d éléments de %2$d albums';
$txt['aeva_from_album'] = 'd\'un album';
$txt['aeva_from_albums'] = 'de %1$d albums';
$txt['aeva_new_playlist'] = 'Nouvelle Playlist';
$txt['aeva_add_to_playlist'] = 'Ajouter à une playlist';
$txt['aeva_playlist_done'] = 'Opération exécutée avec succès.';
$txt['aeva_and'] = 'et';
$txt['aeva_foxy_stats_video'] = 'vidéo';
$txt['aeva_foxy_stats_videos'] = 'vidéos';
$txt['aeva_foxy_stats_audio'] = 'fichier audio';
$txt['aeva_foxy_stats_audios'] = 'fichiers audio';
$txt['aeva_foxy_stats_image'] = 'image';
$txt['aeva_foxy_stats_images'] = 'images';
$txt['aeva_foxy_audio_list'] = 'Liste audio';
$txt['aeva_foxy_video_list'] = 'Liste de vidéos';
$txt['aeva_foxy_image_list'] = 'Liste d\'images';
$txt['aeva_foxy_media_list'] = 'Liste multimédia';
$txt['aeva_foxy_add_tag'] = 'Cliquez <a href="%1$s">ici</a> pour insérer le tag dans votre message et fermer la fenêtre. (Expérimental !)';
$txt['aeva_foxy_and_children'] = 'et ses sous-albums';

// Lightbox strings
$txt['aeva_lightbox_section'] = 'Highslide (Transitions animées)';
$txt['aeva_lightbox_enable'] = 'Activer Highslide';
$txt['aeva_lightbox_enable_info'] = 'Highslide est un script utilisé pour afficher les images via une animation quand vous cliquez sur une vignette.';
$txt['aeva_lightbox_outline'] = 'Ombre portée';
$txt['aeva_lightbox_outline_info'] = 'Définit le type d\'ombre qui entourera le contenu agrandi. <i>drop-shadow</i> est une ombre portée simple, tandis que <i>rounded-white</i> ajoute des bords blancs, des coins arrondis et une ombre portée plus petite.';
$txt['aeva_lightbox_expand'] = 'Durée de l\'animation';
$txt['aeva_lightbox_expand_info'] = '<i>En millisecondes</i>. Définit le temps pris par le zoom pour se réaliser.';
$txt['aeva_lightbox_autosize'] = 'Adaptation à l\'échelle';
$txt['aeva_lightbox_autosize_info'] = 'Permet aux images trop grandes d\'être réduites pour ne pas dépasser la taille de la fenêtre du navigateur. Cliquez ensuite sur l\'icône Agrandir pour les voir en taille normale.';
$txt['aeva_lightbox_fadeinout'] = 'Fondu enchaîné';
$txt['aeva_lightbox_fadeinout_info'] = 'Ajoute un effet de fondu enchaîné à l\'animation.';

// Highslide Javascript strings.
// Escape single quotes twice (\\\' instead of \') otherwise it won't work.
$txt['aeva_hs_close_title'] = 'Fermer (Echap)';
$txt['aeva_hs_move'] = 'Déplacer';
$txt['aeva_hs_loading'] = 'Chargement...';
$txt['aeva_hs_clicktocancel'] = 'Cliquez pour annuler';
$txt['aeva_hs_clicktoclose'] = 'Cliquez pour fermer, glissez pour déplacer';
$txt['aeva_hs_expandtoactual'] = 'Afficher en taille réelle (F)';
$txt['aeva_hs_focus'] = 'Cliquez pour mettre en avant';
$txt['aeva_hs_previous'] = 'Précédent (Flèche gauche)';
$txt['aeva_hs_next'] = 'Suivante (Flèche droite)';
$txt['aeva_hs_play'] = 'Diaporama (Espace)';
$txt['aeva_hs_pause'] = 'Pause Diaporama (Espace)';

// Help strings
$txt['aeva_add_keywords_sub'] = 'Utilisez des virgules pour séparer les mots-clés. Si un mot-clé contient une virgule, entourez-le de guillemets. Si votre mot-clé contient des guillemets, oh et puis zut débrouillez-vous.';
$txt['aeva_add_embed_sub'] = 'Adresse URL proposant la vidéo (sur YouTube ou autre). À n\'utiliser que si vous n\'uploadez pas de fichier.';
$txt['aeva_will_be_approved'] = 'Votre envoi devra être approuvé par un modérateur avant d\'être visible en ligne.';
$txt['aeva_com_will_be_approved'] = 'Votre commentaire devra être approuvé par un modérateur avant d\'être mis en ligne.';
$txt['aeva_album_will_be_approved'] = 'Votre album devra être approuvé par un modérateur avant d\'être mis en ligne.';
$txt['aeva_what_album'] = 'Cet élément sera ajouté à l\'album <a href="%s">%s</a>';
$txt['aeva_what_album_select'] = 'Choisissez l\'album où envoyer cet élément&nbsp;';
$txt['aeva_no_listing'] = 'Pas d\'éléments à lister';
$txt['aeva_resized'] = 'Cliquez sur l\'image pour la voir en taille réelle.';
// Escape single quotes twice (\\\' instead of \') for aeva_confirm, otherwise it won't work.
$txt['aeva_confirm'] = 'Êtes-vous sûr de vouloir faire cela ?';
$txt['aeva_reported'] = 'Cet élément a été signalé, il sera prochainement passé en revue par un modérateur.<br /><br /><a href="%s">Retour</a>';
$txt['aeva_edit_file_subtext'] = 'Laissez vide si vous ne souhaitez pas ré-envoyer le fichier et remplacer l\'ancien.';
$txt['aeva_embed_sub_edit'] = 'Si vous changez l\'adresse URL d\'intégration, elle écrasera les URL ou fichiers préexistants liés à cet élément';
$txt['aeva_editing_item'] = 'Vous êtes en train de modifier cet élément&nbsp;: <a href="%s">%s</a>';
$txt['aeva_editing_com'] = 'Modification du commentaire';
$txt['aeva_moving_item'] = 'Déplacement de l\'élément';
$txt['aeva_search_by_mem_sub'] = 'Entrez les noms des membres en les séparant par une virgule. Laissez vide pour chercher parmi les éléments de tous les membres.';
$txt['aeva_passwd_protected'] = 'Cet album est protégé par un mot de passe, merci de l\'entrer pour continuer.';
$txt['aeva_user_albums_desc'] = 'D\'ici vous pouvez gérer vos albums, en ajouter ou les modifier.';
$txt['aeva_click_to_close'] = 'Cliquez pour fermer';
$txt['aeva_multi_dl_wait'] = 'Le script a été mis en pause pour éviter de surcharger le serveur. %s éléments terminés sur %s.';
$txt['aeva_too_many_items'] = 'Trop d\'éléments, merci de restreindre votre choix.';

// Errors
$txt['aeva_albumSwitchError'] = 'Un ou plusieurs albums utilisent actuellement le profil que vous essayez de supprimer. Veuillez d\'abord choisir un profil vers lequel les transférer.';
$txt['aeva_accessDenied'] = 'Désolé, mais vous n\'avez pas l\'autorisation d\'accéder à la galerie';
$txt['aeva_add_not_allowed'] = 'Désolé, mais vous n\'avez pas l\'autorisation d\'envoyer ce type d\'élément dans cet album';
$txt['aeva_add_album_not_set'] = 'Pas d\'album spécifié';
$txt['aeva_album_denied'] = 'L\'accès à cet album a été refusé';
$txt['aeva_file_not_specified'] = 'Vous n\'avez pas spécifié de fichier à envoyer. Ou peut-être avez-vous essayé d\'envoyer un fichier trop imposant pour le serveur ?';
$txt['aeva_title_not_specified'] = 'Vous n\'avez pas spécifié de titre';
$txt['aeva_invalid_extension'] = 'Le fichier n\'a pas une extension valide (%s)';
$txt['aeva_upload_file_too_big'] = 'La taille du fichier (% Ko) est supérieure à la taille autorisée';
$txt['aeva_upload_dir_not_writable'] = 'Le dossier d\'upload n\'a pas les droits d\'écriture';
$txt['aeva_upload_failed'] = 'Une erreur s\'est produite pendant l\'envoi, merci de réessayer ou de contacter l\'administrateur.<br />%s';
$txt['aeva_error_height'] = 'La hauteur de l\'image (%s pixels) est supérieure au maximum autorisé';
$txt['aeva_error_width'] = 'La largeur de l\'image (%s pixels) est supérieure au maximum autorisé';
$txt['aeva_invalid_embed_link'] = 'L\'adresse URL d\'intégration n\'est pas correcte, ou provient d\'un site non supporté. Si vous tentez d\'intégrer une image externe, vérifiez que l\'add-on Foxy! pour Aeva Media est bien installé.';
$txt['aeva_banned_full'] = 'Désolé, vous êtes banni de la galerie !';
$txt['aeva_banned_post'] = 'Désolé, vous n\'avez plus l\'autorisation de publier des éléments !';
$txt['aeva_banned_comment_post'] = 'Désolé, vous n\'avez plus l\'autorisation de commenter !';
$txt['aeva_item_not_found'] = 'L\'élément spécifié est introuvable';
$txt['aeva_item_access_denied'] = 'Vous n\'êtes pas autorisé à accéder à cet élément';
$txt['aeva_invalid_rating'] = 'La note est invalide';
$txt['aeva_rate_denied'] = 'Vous n\'êtes pas autorisé à voter pour des éléments';
$txt['aeva_re-rating_denied'] = 'Vous n\'avez pas l\'autorisation de changer votre vote';
$txt['aeva_comment_not_allowed'] = 'Vous n\'êtes pas autorisé à laisser des commentaires';
$txt['aeva_comment_left_empty'] = 'Vous n\'avez pas laissé de commentaire';
$txt['aeva_com_report_denied'] = 'Vous n\'êtes pas autorisé à signaler des commentaires';
$txt['aeva_report_left_empty'] = 'Vous n\'avez pas donné de raison';
$txt['aeva_item_report_denied'] = 'Vous n\'êtes pas autorisé à signaler des éléments';
$txt['aeva_edit_denied'] = 'Vous n\'êtes pas autorisé à modifier cet élément';
$txt['aeva_com_not_found'] = 'Commentaire introuvable';
$txt['aeva_delete_denied'] = 'Vous n\'êtes pas autorisé à supprimer un élément';
$txt['aeva_move_denied'] = 'Vous n\'êtes pas autorisé à déplacer un élément';
$txt['aeva_invalid_album'] = 'Votre soumission a été effectuée dans un album invalide';
$txt['aeva_filemove_failed'] = 'Un problème est apparu lors du déplacement des fichiers';
$txt['aeva_search_left_empty'] = 'Les mots-clé de recherche ont été laissés vides';
$txt['aeva_no_search_option_selected'] = 'Aucun paramètre n\'a été spécifié pour la recherche';
$txt['aeva_search_mem_not_found'] = 'Aucun membre ne correspond à votre requête';
$txt['aeva_search_denied'] = 'Vous n\'êtes pas autorisé à rechercher un élément dans la galerie';
$txt['aeva_album_not_found'] = 'Album introuvable';
$txt['aeva_unseen_denied'] = 'Vous n\'êtes pas autorisé à voir les éléments non visités';
$txt['aeva_dest_failed'] = 'Impossible de trouver la bonne destination sur le serveur, merci de contacter l\'administrateur.';
$txt['aeva_not_a_dir'] = 'L\'administrateur n\'a pas correctement renseigné le répertoire de données d\'Aeva Media. Si vous êtes admin, allez le corriger dans les paramètres. Sinon, envoyez-lui un message et moquez-vous de lui. Mais pas trop hein, faut rester cool quoi, y\'a pas mort d\'homme.';
$txt['aeva_size_mismatch'] = 'La taille de ce fichier a changé depuis sa mise en ligne initiale. Demandez à l\'administrateur s\'il a renvoyé manuellement le fichier par FTP. Si oui, dites-lui de recommencer mais cette fois en mode <i>binaire</i>, pas <i>ASCII</i> ou <i>auto</i>...';

// Admin general strings
$txt['aeva_admin_labels_index'] = 'Accueil';
$txt['aeva_admin_labels_settings'] = 'Paramètres';
$txt['aeva_admin_labels_embed'] = 'Intégration';
$txt['aeva_admin_labels_reports'] = 'Signalements';
$txt['aeva_admin_labels_submissions'] = 'Soumissions';
$txt['aeva_admin_labels_bans'] = 'Bannissements';
$txt['aeva_admin_labels_albums'] = 'Albums';
$txt['aeva_admin_labels_maintenance'] = 'Maintenance';
$txt['aeva_admin_labels_about'] = 'À propos';
$txt['aeva_admin_labels_ftp'] = 'Import par FTP';
$txt['aeva_admin_labels_perms'] = 'Permissions';
$txt['aeva_admin_labels_quotas'] = 'Quotas';
$txt['aeva_admin_settings_config'] = 'Configuration';
$txt['aeva_admin_settings_title_main'] = 'Réglages principaux';
$txt['aeva_admin_settings_title_security'] = 'Réglages de sécurité';
$txt['aeva_admin_settings_title_limits'] = 'Limites';
$txt['aeva_admin_settings_title_tag'] = 'Tag [smg] et intégration';
$txt['aeva_admin_settings_title_misc'] = 'Divers';
$txt['aeva_admin_settings_welcome'] = 'Message d\'accueil';
$txt['aeva_admin_settings_welcome_subtext'] = 'Laissez vide pour utiliser $txt[\'aeva_welcome\'] dans le fichier Modifications.english.php (que vous pouvez traduire à votre guise), ou le message d\'accueil par défaut.';
$txt['aeva_admin_settings_data_dir_path'] = 'Chemin vers le répertoire de données';
$txt['aeva_admin_settings_data_dir_path_subtext'] = 'Chemin sur le serveur (exemple&nbsp;: /home/www/mgal_data)';
$txt['aeva_admin_settings_data_dir_url'] = 'Adresse du répertoire de données';
$txt['aeva_admin_settings_data_dir_url_subtext'] = 'Même chemin, mais accessible par le web (exemple&nbsp;: http://mysite.com/mgal_data)';
$txt['aeva_admin_settings_max_dir_files'] = 'Nombre maximal de fichiers par répertoire';
$txt['aeva_admin_settings_max_dir_size'] = 'Taille maximale d\'un répertoire';
$txt['aeva_admin_settings_enable_re-rating'] = 'Autoriser à changer son vote';
$txt['aeva_admin_settings_use_exif_date'] = 'Utiliser la date Exif si possible';
$txt['aeva_admin_settings_use_exif_date_subtext'] = 'Si le fichier contient des données Exif, la date de publication affichée sera celle donnée par Exif au lieu de l\'heure actuelle.';
$txt['aeva_admin_settings_title_files'] = 'Réglages pour les fichiers';
$txt['aeva_admin_settings_title_previews'] = 'Réglages pour les prévisualisations';
$txt['aeva_admin_settings_max_file_size'] = 'Taille maximale des fichiers';
$txt['aeva_admin_settings_max_file_size_subtext'] = 'Mettez à 0 et utilisez la section Quotas pour affiner.';
$txt['aeva_admin_settings_max_width'] = 'Largeur maximale';
$txt['aeva_admin_settings_max_height'] = 'Hauteur maximale';
$txt['aeva_admin_settings_allow_over_max'] = 'Autoriser le redimensionnement';
$txt['aeva_admin_settings_allow_over_max_subtext'] = 'Si l\'image envoyée dépasse les dimensions autorisées, le serveur tentera de la redimensionner à la taille maximale autorisée. À éviter pour les serveurs surchargés. Choisissez &quot;Non&quot; pour rejeter l\'image.';
$txt['aeva_admin_settings_upload_security_check'] = 'Activer la sécurité pendant l\'envoi de fichiers';
$txt['aeva_admin_settings_upload_security_check_subtext'] = 'Permet d\'empêcher l\'envoi de fichiers malicieux, mais peut parfois rejeter des fichiers sains. Inutile de l\'activer, sauf si vous avez des utilisateurs d\'IE vraiment, mais vraiment idiots, et qui cherchent les ennuis.';
$txt['aeva_admin_settings_log_access_errors'] = 'Archiver les erreurs d\'accès';
$txt['aeva_admin_settings_log_access_errors_subtext'] = 'Si activé, toutes les erreurs d\'accès refusé dans Aeva Media seront archivées dans le journal d\'erreurs.';
$txt['aeva_admin_settings_ftp_file'] = 'Chemin d\'accès du fichier Safe Mode';
$txt['aeva_admin_settings_ftp_file_subtext'] = 'Lisez le fichier MGallerySafeMode.php pour plus d\'informations. Nécessaire si votre serveur est en Safe Mode !';
$txt['aeva_admin_settings_jpeg_compression'] = 'Compression Jpeg';
$txt['aeva_admin_settings_jpeg_compression_subtext'] = 'Qualité des images redimensionnées (dont les aperçus et les vignettes), de 0 (fichiers légers, mauvaise qualité) à 100 (gros fichiers, haute qualité). La valeur par défaut (80) est recommandée. Restez entre 65 et 85.';
$txt['aeva_admin_settings_exif'] = 'Exif';
$txt['aeva_admin_settings_layout'] = 'Apparence';
$txt['aeva_admin_settings_show_extra_info'] = 'Montrer les données Exif';
$txt['aeva_admin_settings_show_info'] = 'Métadonnées Exif à montrer';
$txt['aeva_admin_settings_show_info_subtext'] = 'Les images prises par des appareils numériques renferment souvent des informations utiles, telles que l\'heure où a été pris un cliché. Vous pouvez choisir de les montrer ou pas.';
$txt['aeva_admin_settings_num_items_per_page'] = 'Nombre d\'éléments par page';
$txt['aeva_admin_settings_max_thumbs_per_page'] = 'Tags [smg] max par page';
$txt['aeva_admin_settings_max_thumbs_per_page_subtext'] = 'Nombre maximal de tags [smg] autorisés par page (ceux-ci sont transformés en vignettes)';
$txt['aeva_admin_settings_recent_item_limit'] = 'Derniers éléments à montrer';
$txt['aeva_admin_settings_random_item_limit'] = 'Éléments au hasard à montrer';
$txt['aeva_admin_settings_recent_comments_limit'] = 'Derniers commentaires à montrer';
$txt['aeva_admin_settings_recent_albums_limit'] = 'Derniers albums à montrer';
$txt['aeva_admin_settings_max_thumb_width'] = 'Largeur maximale pour la vignette';
$txt['aeva_admin_settings_max_thumb_height'] = 'Hauteur maximale pour la vignette';
$txt['aeva_admin_settings_max_preview_width'] = 'Largeur maximale pour l\'aperçu';
$txt['aeva_admin_settings_max_preview_width_subtext'] = 'L\'aperçu est une image intermédiaire cliquable qui est montrée sur la fiche consacrée à l\'image en taille réelle. Mettez à 0 pour désactiver sa génération. <b>Attention</b>, si les aperçus sont désactivés, les images de grande taille déformeront peut-être l\'apparence de vos pages.';
$txt['aeva_admin_settings_max_preview_height'] = 'Hauteur maximale pour l\'aperçu';
$txt['aeva_admin_settings_max_preview_height_subtext'] = 'Même chose. Si la largeur ou la hauteur est à 0, la génération d\'aperçus est désactivée.';
$txt['aeva_admin_settings_max_bigicon_width'] = 'Largeur maximale pour l\'icône';
$txt['aeva_admin_settings_max_bigicon_width_subtext'] = 'Les icônes d\'album ont une vignette (dont la taille est la même que pour les vignettes d\'éléments), ainsi qu\'une icône de taille arbitraire, montrée uniquement sur les pages des albums. Vous pouvez régler ici la largeur maximale de cette icône.';
$txt['aeva_admin_settings_max_bigicon_height'] = 'Hauteur maximale pour l\'icône';
$txt['aeva_admin_settings_max_bigicon_height_subtext'] = 'Même chose. Vous pouvez régler ici la hauteur maximale de cette icône.';
$txt['aeva_admin_settings_max_title_length'] = 'Longueur maximale des titres';
$txt['aeva_admin_settings_max_title_length_subtext'] = 'Nombre maximal de caractères à afficher pour les titres au-dessus des vignettes. Si coupés, ils restent lisibles en passant la souris sur la vignette.';
$txt['aeva_admin_settings_enable_cache'] = 'Activer le cache';
$txt['aeva_admin_settings_image_handler'] = 'Gestionnaire d\'images';
$txt['aeva_admin_settings_show_sub_albums_on_index'] = 'Montrer les sous-albums dans l\'index';
$txt['aeva_admin_settings_use_lightbox'] = 'Utiliser Highslide (transitions animées)';
$txt['aeva_admin_settings_use_lightbox_subtext'] = 'Highslide est un module Javascript qui ajoute des ombres portées aux images, ainsi que des transitions animées en cliquant sur les aperçus (zoom et fondu enchaîné). Désactivez pour empêcher l\'utilisation de HS sur tous les albums. Si activé, les propriétaires d\'albums pourront tout de même désactiver Highslide sur leurs albums via leurs réglages par album.';
$txt['aeva_admin_settings_album_edit_unapprove'] = 'Nécessiter une réapprobation après modification sur un album';
$txt['aeva_admin_settings_item_edit_unapprove'] = 'Nécessiter une réapprobation après modification sur un élément';
$txt['aeva_admin_settings_show_linking_code'] = 'Afficher le code pour lier vers les images';
$txt['aeva_admin_settings_ffmpeg_installed'] = 'FFMPEG a été trouvé sur ce serveur, ses fonctions peuvent être utilisées pour les fichiers vidéo. S\'il est activé, il sera utilisé pour créer des vignettes et pour montrer des informations supplémentaires.';
$txt['aeva_admin_settings_entities_convert'] = 'Convertir les chaînes UTF-8 en entités&nbsp;?';
$txt['aeva_admin_settings_entities_convert_subtext'] = 'Les chaînes prendront un peu plus de place dans la base de données, mais les textes seront toujours lisibles.';
$txt['aeva_admin_settings_prev_next'] = 'Montrer les éléments précédents et suivants&nbsp;?';
$txt['aeva_admin_settings_prev_next_subtext'] = 'Activez cette option pour montrer sur les pages d\'éléments des raccourcis (image ou texte) vers les éléments précédents et suivants.';
$txt['aeva_admin_settings_default_tag_type'] = 'Taille par défaut dans les tags [smg]&nbsp;?';
$txt['aeva_admin_settings_default_tag_type_subtext'] = 'Choisissez le type d\'image à afficher par défaut quand aucun type n\'est spécifié pour les images affichées via le tag [smg id=xxx type=xxx]';
$txt['aeva_admin_settings_num_items_per_line'] = 'Nombre d\'éléments par ligne';
$txt['aeva_admin_settings_num_items_per_line_ext'] = 'Nombre d\'éléments par ligne';
$txt['aeva_admin_settings_my_docs'] = 'Documents autorisés';
$txt['aeva_admin_settings_my_docs_subtext'] = 'Vous pouvez choisir la liste des extensions autorisées pour les Documents envoyés. Séparez-les par des virgules (ex: "zip,pdf"). Si vous voulez remettre la liste à zéro, voici les extensions supportées par défaut&nbsp;: %s';
$txt['aeva_admin_settings_player_color'] = 'Couleur du lecteur audio/vidéo';
$txt['aeva_admin_settings_player_color_subtext'] = 'En code héxa. Par défaut, blanc (FFFFFF)';
$txt['aeva_admin_settings_player_bcolor'] = 'Couleur de fond du lecteur audio/vidéo';
$txt['aeva_admin_settings_player_bcolor_subtext'] = 'En code héxa. Par défaut, noir (000000)';
$txt['aeva_admin_settings_audio_player_width'] = 'Largeur du lecteur audio';
$txt['aeva_admin_settings_audio_player_width_subtext'] = 'En pixels. Par défaut, 400';
$txt['aeva_admin_settings_phpini_subtext'] = 'Cette variable serveur limite la taille des envois, elle est configurée via le fichier php.ini (voir documentation à droite)';
$txt['aeva_admin_settings_clear_thumbnames'] = 'Laisser en clair les adresses des vignettes';
$txt['aeva_admin_settings_clear_thumbnames_subtext'] = 'Si activé, les vignettes seront liées directement par leur URL. Gain de temps mais confidentialité amoindrie.';
$txt['aeva_admin_settings_album_columns'] = 'Nombre de sous-albums par ligne';
$txt['aeva_admin_settings_album_columns_subtext'] = 'Par défaut, 1. Si vous avez beaucoup de sous-albums, n\'hésitez pas à mettre 2 ou 3 colonnes pour avoir plus d\'albums par ligne.';
$txt['aeva_admin_settings_icons_only'] = 'Utiliser les icônes comme raccourcis';
$txt['aeva_admin_settings_icons_only_subtext'] = 'Si cette option est activée, seules les icônes seront montrées sous les vignettes des boîtes d\'éléments, comme par exemple les listes d\'éléments sur les pages d\'albums. <i>Par</i>, <i>Visites</i>, etc. seront cachés pour gagner en place.';

$txt['aeva_admin_add_album'] = 'Créer un Album';
$txt['aeva_admin_filter_normal_albums'] = 'Filtrer les albums normaux';
$txt['aeva_admin_filter_featured_albums'] = 'Filtrer les albums stars';
$txt['aeva_admin_moderation'] = 'Modération';
$txt['aeva_admin_moving_album'] = 'Déplacer un album';
$txt['aeva_admin_cancel_moving'] = 'Annuler le déplacement';
$txt['aeva_admin_type'] = 'Type';
$txt['aeva_admin_edit'] = 'Modifier';
$txt['aeva_admin_delete'] = 'Effacer';
$txt['aeva_admin_approve'] = 'Approuver';
$txt['aeva_admin_unapprove'] = 'Désapprouver';
$txt['aeva_admin_before'] = 'Avant';
$txt['aeva_admin_after'] = 'Après';
$txt['aeva_admin_child_of'] = 'Enfant de';
$txt['aeva_admin_target'] = 'Cible';
$txt['aeva_admin_position'] = 'Position';
$txt['aeva_admin_membergroups'] = 'Groupes de membres';
$txt['aeva_admin_membergroups_subtxt'] = 'Choisissez les groupes de membres qui seront autorisés à accéder à l\'album et à son contenu.<br />
<ul class="aevadesc">
	<li>Si les <strong>groupes primaires</strong> (indiqués en gras) sont cochés, tous les membres du forum pourront accéder à l\'album, il est donc inutile de cocher les autres groupes (sauf Invités).</li>
	<li>Accès en <strong>Lecture</strong> : le groupe peut consulter l\'album et ses éléments, et utiliser les éventuelles permissions accordées (commenter, noter, etc.)</li>
	<li>Accès en <strong>Écriture</strong> : le groupe peut contribuer à l\'album en y envoyant des éléments.</li>
</ul>';
$txt['aeva_admin_membergroups_primary'] = 'Ce groupe est utilisé comme groupe primaire par un ou plusieurs membres.';
$txt['aeva_admin_passwd'] = 'Mot de passe';
$txt['aeva_admin_move'] = 'Déplacer';
$txt['aeva_admin_total_submissions'] = 'Nombre de soumissions';
$txt['aeva_admin_maintenance_tasks'] = 'Tâches de maintenance';
$txt['aeva_admin_maintenance_utils'] = 'Utilitaires de maintenance';
$txt['aeva_admin_maintenance_regen'] = 'Régénération des vignettes et aperçus';
$txt['aeva_admin_maintenance_recount'] = 'Recompter les totaux';
$txt['aeva_admin_maintenance_recount_subtext'] = 'Recompte les totaux et les statistiques et les met à jour. Peut être utilisé pour réparer des statistiques incorrectes.';
$txt['aeva_admin_maintenance_finderrors'] = 'Recherche d\'erreurs';
$txt['aeva_admin_maintenance_finderrors_subtext'] = 'Cherche les erreurs telles que fichier manquant (physique ou dans la base de données), ou ID de dernier message ou d\'élément incorrect.';
$txt['aeva_admin_maintenance_prune'] = 'Nettoyage';
$txt['aeva_admin_maintenance_prune_subtext'] = 'Utilitaire pour purger les commentaires/éléments avec des paramètres spécifiques';
$txt['aeva_admin_maintenance_browse'] = 'Parcourir les fichiers';
$txt['aeva_admin_maintenance_browse_subtext'] = 'Utilitaire pour parcourir les fichiers, montre aussi l\'utilisation d\'espace d\'un dossier/fichier';
$txt['aeva_maintenance_done'] = 'Maintenance effectuée';
$txt['aeva_pruning'] = 'Nettoyage';
$txt['aeva_admin_maintenance_prune_days'] = ' jours au-delà desquels l\'élément est considéré comme ancien';
$txt['aeva_admin_maintenance_prune_last_comment_age'] = 'Dernier commentaire plus vieux que';
$txt['aeva_admin_maintenance_prune_max_coms'] = 'Nombre de commentaires inférieur à';
$txt['aeva_admin_maintenance_prune_max_views'] = 'Nombre de visites inférieur à';
$txt['aeva_admin_maintenance_checkfiles'] = 'Éliminer les fichiers superflus';
$txt['aeva_admin_maintenance_checkfiles_subtext'] = 'Cherche les fichiers superflus (introuvables dans la table aeva_media), et offre la possibilité de les supprimer.';
$txt['aeva_admin_maintenance_checkorphans'] = 'Éliminer les fichiers orphelins';
$txt['aeva_admin_maintenance_checkorphans_subtext'] = 'Cherche les fichiers orphelins (introuvables dans la table aeva_files), et offre la possibilité de les supprimer. <strong>Attention !</strong> Si vous lancez cette opération, votre galerie sera <strong>inutilisable</strong> tant que ses trois phases ne seront pas terminées. Le processus peut prendre beaucoup de temps sur une galerie conséquente.';
$txt['aeva_admin_maintenance_regen_all'] = 'Régénérer les vignettes et aperçus';
$txt['aeva_admin_maintenance_regen_embed'] = 'Régénérer les vignettes des éléments intégrés';
$txt['aeva_admin_maintenance_regen_thumb'] = 'Régénérer les vignettes';
$txt['aeva_admin_maintenance_regen_preview'] = 'Régénérer les aperçus';
$txt['aeva_admin_maintenance_regen_all_subtext'] = 'Cette fonction supprimera et recréera tous les aperçus et vignettes existants, mais seulement s\'ils peuvent être recréés à partir de leur fichier source.';
$txt['aeva_admin_maintenance_regen_embed_subtext'] = 'Cette fonction supprimera et recréera les vignettes, mais uniquement pour les <b>éléments intégrés</b> (YouTube ou autres).';
$txt['aeva_admin_maintenance_regen_thumb_subtext'] = 'Cette fonction supprimera et recréera toutes les vignettes existantes, mais uniquement si elles peuvent être recréées à partir du fichier source ou de l\'aperçu.';
$txt['aeva_admin_maintenance_regen_preview_subtext'] = 'Cette fonction supprimera et recréera tous les aperçus existants, mais uniquement s\'ils peuvent être recréés à partir du fichier source.';
$txt['aeva_admin_maintenance_operation_pending'] = 'L\'opération a été interrompue pour éviter de surcharger le serveur. Elle reprendra automatiquement dans une seconde. %s éléments terminés sur %s.';
$txt['aeva_admin_maintenance_operation_pending_raw'] = 'L\'opération a été interrompue pour éviter de surcharger le serveur. Elle reprendra automatiquement dans une seconde.';
$txt['aeva_admin_maintenance_operation_phase'] = 'Phase %d/%d';
$txt['aeva_admin_maintenance_all_tasks'] = 'Toutes les tâches';
$txt['aeva_admin_labels_modlog'] = 'Journal';
$txt['aeva_admin_action_type'] = 'Type d\'action';
$txt['aeva_admin_reported_item'] = 'Élément signalé';
$txt['aeva_admin_reported_by'] = 'Signalé par';
$txt['aeva_admin_reported_on'] = 'Signalé le';
$txt['aeva_admin_del_report'] = 'Supprimer le rapport';
$txt['aeva_admin_del_report_item'] = 'Supprimer l\'élément signalé';
$txt['aeva_admin_report_reason'] = 'Raison du signalement';
$txt['aeva_admin_banned'] = 'Banni';
$txt['aeva_admin_banned_on'] = 'Banni le';
$txt['aeva_admin_expires_on'] = 'Expire le';
$txt['aeva_never'] = 'Jamais';
$txt['aeva_admin_ban_type'] = 'Type de bannissement';
$txt['aeva_admin_ban_type_1'] = 'Complet';
$txt['aeva_admin_ban_type_2'] = 'Ajout d\'éléments';
$txt['aeva_admin_ban_type_3'] = 'Ajout de commentaires';
$txt['aeva_admin_ban_type_4'] = 'Ajout d\'éléments et de commentaires';
$txt['aeva_admin_banning'] = 'Bannissement d\'un membre';
$txt['aeva_admin_bans_add'] = 'Ajouter un bannissement';
$txt['aeva_unapproved_items_notice'] = 'Il y a %2$d élément(s) non approuvé(s). <a href="%1$s">Cliquez ici pour les voir</a>.';
$txt['aeva_unapproved_coms_notice'] = 'Il y a %2$d commentaire(s) non approuvé(s). <a href="%1$s">Cliquez ici pour les voir</a>.';
$txt['aeva_unapproved_albums_notice'] = 'Il y a %2$d album(s) non approuvé(s). <a href="%1$s">Cliquez ici pour les voir</a>.';
$txt['aeva_reported_items_notice'] = '%2$d élément(s) ont été signalés. <a href="%1$s">Cliquez ici pour les voir</a>';
$txt['aeva_reported_comments_notice'] = '%2$d commentaire(s) ont été signalés. <a href="%1$s">Cliquez ici pour les voir</a>';
$txt['aeva_admin_modlog_approval_item'] = 'Approuvé l\'élément <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_ua_item'] = 'Désapprouvé l\'élément <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_item'] = 'Supprimé l\'élément %s (était en attente d\'approbation)';
$txt['aeva_admin_modlog_approval_com'] = 'Approuvé le commentaire <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_com'] = 'Supprimé un commentaire de l\'élément %s (était en attente d\'approbation)';
$txt['aeva_admin_modlog_approval_album'] = 'Approuvé l\'album <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_album'] = 'Supprimé l\'album %s (était en attente d\'approbation)';
$txt['aeva_admin_modlog_delete_item'] = 'Supprimé l\'élément %s';
$txt['aeva_admin_modlog_delete_album'] = 'Supprimé l\'album %s';
$txt['aeva_admin_modlog_delete_comment'] = 'Supprimé un commentaire de l\'élément %s';
$txt['aeva_admin_modlog_delete_report_item_report'] = 'Supprimé une plainte concernant l\'élément #%s';
$txt['aeva_admin_modlog_delete_report_comment_report'] = 'Supprimé une plainte concernant le commentaire #%s';
$txt['aeva_admin_modlog_delete_item_item_report'] = 'Supprimé l\'élément signalé #%s';
$txt['aeva_admin_modlog_delete_item_comment_report'] = 'Supprimé le commentaire signalé #%s';
$txt['aeva_admin_modlog_ban_add'] = 'Banni <a href="%s">%s</a>';
$txt['aeva_admin_modlog_ban_delete'] = 'Débanni <a href="%s">%s</a>';
$txt['aeva_admin_modlog_prune_item'] = 'Purgé %s élément(s)';
$txt['aeva_admin_modlog_prune_comment'] = 'Purgé %s commentaire(s)';
$txt['aeva_admin_modlog_move'] = 'Déplacé <a href=%s">%s</a> de l\'album <a href="%s">%s</a> vers <a href="%s">%s</a>';
$txt['aeva_admin_modlog_qsearch'] = 'Recherche rapide par membre';
$txt['aeva_admin_modlog_filter'] = 'Journal de modération filtré par <a href="%s">%s</a>';
$txt['aeva_admin_view_image'] = 'Voir l\'image';
$txt['aeva_admin_live'] = 'En direct de SMF-Media.com';
$txt['aeva_admin_ftp_files'] = 'Fichiers dans le dossier FTP';
$txt['aeva_admin_profile_add'] = 'Créer un profil';
$txt['aeva_admin_prof_name'] = 'Nom du profil';
$txt['aeva_admin_create_prof'] = 'Créer le profil';
$txt['aeva_admin_members'] = 'Membres';
$txt['aeva_admin_prof_del_switch'] = 'Passer les albums à ce profil';
$txt['aeva_quota_profile'] = 'Profil de quotas';
$txt['aeva_album_hidden'] = 'Désactiver la navigation';
$txt['aeva_album_hidden_subtxt'] = 'Activez cette option pour empêcher la navigation dans l\'album à tout le monde sauf vous. Ses éléments RESTERONT visionnables aux groupes autorisés. Utile pour faire un album dont les éléments ne doivent être publiés que sur des messages de forum.';
$txt['aeva_allowed_members'] = 'Membres autorisés (lecture)';
$txt['aeva_allowed_members_subtxt'] = 'Entrez la liste des membres, séparés par des virgules, dont vous souhaitez qu\'ils puissent consulter l\'album, même si leurs groupes n\'y sont pas autorisés.';
$txt['aeva_allowed_write'] = 'Membres autorisés (écriture)';
$txt['aeva_allowed_write_subtxt'] = 'Entrez la liste des membres, séparés par des virgules, dont vous souhaitez qu\'ils puissent envoyer des éléments dans l\'album, même si leurs groupes n\'y sont pas autorisés.';
$txt['aeva_denied_members'] = 'Membres bannis (lecture)';
$txt['aeva_denied_members_subtxt'] = 'Entrez la liste des membres, séparés par des virgules, à qui vous souhaitez refuser de consulter l\'album, même si leurs groupes y sont autorisés.';
$txt['aeva_denied_write'] = 'Membres bannis (écriture)';
$txt['aeva_denied_write_subtxt'] = 'Entrez la liste des membres, séparés par des virgules, à qui vous souhaitez refuser d\'envoyer des éléments dans l\'album, même si leurs groupes y sont autorisés.';
$txt['aeva_admin_wselected'] = 'Avec la sélection';
$txt['aeva_admin_apply_perm'] = 'Ajouter permission';
$txt['aeva_admin_clear_perm'] = 'Effacer permission';
$txt['aeva_admin_set_mg_perms'] = 'Utiliser les permissions de ce groupe';
$txt['aeva_admin_readme'] = 'Lisez-Moi';
$txt['aeva_admin_changelog'] = 'Changelog';

// Admin error strings
// Escape single quotes twice (\\\' instead of \') for aeva_admin_album_confirm, otherwise it won't work.
$txt['aeva_admin_album_confirm'] = 'Êtes-vous sûr de vouloir supprimer cet album ? Cela supprimera aussi les éléments et les commentaires inclus.';
$txt['aeva_admin_name_left_empty'] = 'Le nom n\'a pas été entré';
$txt['aeva_admin_invalid_target'] = 'Cible spécifiée invalide';
$txt['aeva_admin_invalid_position'] = 'Position spécifiée invalide';
$txt['aeva_admin_prune_invalid_days'] = 'Données &quot;jours&quot; non valides';
$txt['aeva_admin_no_albums'] = 'Pas d\'album spécifié';
$txt['aeva_admin_rm_selected'] = 'Supprimer la sélection';
$txt['aeva_admin_rm_all'] = 'Tout supprimer';
$txt['aeva_report_not_found'] = 'Signalement introuvable';
$txt['aeva_admin_bans_mems_empty'] = 'Aucun membre n\'a été spécifié';
$txt['aeva_admin_bans_mems_not_found'] = 'Les membres spécifiés sont introuvables';
$txt['aeva_ban_not_found'] = 'Bannissement introuvable';
$txt['aeva_admin_already_banned'] = 'Utilisateur déjà banni';
$txt['aeva_admin_album_dir_failed'] = 'La création du répertoire de cet album a échoué, assurez-vous que mgal_data/ et mgal_data/albums/ sont chmoddés à 0777 ou 0755.';
$txt['aeva_admin_unique_permission'] = 'Vous devez ne sélectionner qu\'une option';
$txt['aeva_admin_quick_none'] = 'Pas d\'option sélectionnée';
$txt['aeva_admin_invalid_groups'] = 'Une sélection invalide a été détectée. Peut-être le groupe sélectionné n\'existe-t-il pas. Si vous copiez des permissions, assurez-vous d\'avoir sélectionné au moins un groupe, et de ne pas y avoir mis le groupe dont vous copiez les permissions';

// Admin help strings
$txt['aeva_admin_desc'] = 'Administration Aeva Media';
$txt['aeva_admin_settings_desc'] = 'Vous êtes sur la page générale de configuration d\'Aeva Media.';
$txt['aeva_admin_embed_desc'] = 'Vous êtes sur la page de configuration de l\'intégration automatique d\'Aeva Media. Vous pouvez y activer ou désactiver l\'intégration des liens multimédia provenant de sites tels que YouTube. Vous pouvez également consulter la liste des sites supportés, et les activer séparément.';
$txt['aeva_admin_albums_desc'] = 'Vous êtes sur la page d\'administration des albums. Vous pouvez y gérer l\'ajout, la suppression, la modification et le déplacement d\'albums. En cliquant sur le bouton <strong>+</strong>, vous obtiendrez plus d\'informations au sujet d\'un album.';
$txt['aeva_admin_subs_desc'] = 'Vous êtes sur la page d\'administration des soumissions, vous pouvez y voir/supprimer/approuver les éléments/commentaires/albums en attente d\'approbation.';
$txt['aeva_admin_maintenance_desc'] = 'Vous êtes sur la page de maintenance, vous y trouverez de nombreuses tâches et fonctions utiles pour votre installation.';
$txt['aeva_admin_modlog_desc'] = 'Vous êtes sur la page du journal de modération d\'Aeva Media, vous y trouverez les activités de modération qui s\'y rapportent.';
$txt['aeva_admin_reports_desc'] = 'Vous êtes sur la page d\'administration des signalements. Vous pouvez y consulter/supprimer les éléments/commentaires signalés par des utilisateurs, ou supprimer des rapports de signalement.';
$txt['aeva_admin_bans_desc'] = 'Vous êtes sur la page d\'administration des bannissements d\'Aeva Media. Vous pouvez y gérer les utilisateurs bannis. Votre toute-puissance n\'a d\'égale que votre cruauté, maître.';
$txt['aeva_admin_about_desc'] = 'Bienvenue dans la zone d\'administration d\'Aeva Media !';
$txt['aeva_admin_passwd_subtxt'] = 'Pour réserver l\'accès à cet album à ceux qui en ont le mot de passe. Sinon, laissez vide.';
$txt['aeva_admin_maintenance_finderror_pending'] = 'Ce script est toujours actif. %s éléments sur %s sont terminés pour le moment.<br /><br /><a href="%s">Veuillez cliquer ici pour continuer</a>. Assurez-vous d\'avoir attendu 1 à 2 secondes afin d\'éviter les surcharges.';
$txt['aeva_admin_finderrors_1'] = 'Les erreurs suivantes ont été trouvées par la recherche d\'erreurs';
$txt['aeva_admin_finderrors_missing_db_file'] = 'L\'entrée de base de données du fichier %s, utilisée pour l\'élément <a href="%s">%s</a>, est manquante.';
$txt['aeva_admin_finderrors_missing_db_thumb'] ='L\'entrée de base de données de la vignette %s, utilisée pour l\'élément <a href="%s">%s</a>, est manquante.';
$txt['aeva_admin_finderrors_missing_db_preview'] ='L\'entrée de base de données de l\'aperçu %s, utilisé pour l\'élément <a href="%s">%s</a>, est manquante.';
$txt['aeva_admin_finderrors_missing_physical_file'] = 'Le fichier %s, utilisé par l\'élément <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_physical_thumb'] = 'Le fichier de la vignette %s, associée à l\'élément <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_physical_preview'] = 'Le fichier de l\'aperçu %s, associé à l\'élément <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_album'] = 'L\'album %s, associé à l\'élément <a href="%s">%s</a>, est manquant.';
$txt['aeva_admin_finderrors_missing_last_comment'] = 'Le commentaire %s, associé à l\'élément <a href="%s">%s</a> en tant que dernier commentaire, est manquant.';
$txt['aeva_admin_finderrors_parent_album_access'] = 'L\'album %s a été mis à jour pour retirer les groupes n\'ayant pas accès à son album parent.';
$txt['aeva_admin_finderrors_done'] = 'Vérification des erreurs terminée. Aucune erreur trouvée&nbsp;!';
$txt['aeva_admin_prune_done_items'] = 'Nettoyage des éléments terminé&nbsp;! %s élément(s), %s commentaire(s) et %s fichier(s) supprimé(s)';
$txt['aeva_admin_prune_done_comments'] = 'Nettoyage des commentaires terminé&nbsp;! %s commentaire(s) supprimé(s)';
$txt['aeva_admin_maintenance_prune_item_help'] = 'Pour le nettoyage des éléments, vous pouvez supprimer les éléments qui ont plus de &quot;x&quot; jours, x pouvant être défini ci-dessous. Il y a quelques options supplémentaires <b>mais sont optionnelles</b>. Les albums peuvent être sélectionnés ensemble ou individuellement.';
$txt['aeva_admin_maintenance_prune_com_help'] = 'Pour le nettoyage des commentaires, vous pouvez nettoyer les commentaires qui ont plus de  &quot;x&quot; jours dans tous les albums, ou dans un album spécifié.';
$txt['aeva_admin_maintenance_checkfiles_done'] = 'Les fichiers inutiles ont tous été supprimés, pour un total de %s fichiers, libérant %s ko d\'espace disque.';
$txt['aeva_admin_maintenance_checkfiles_no_files'] = 'Pas de fichiers superflus trouvés';
$txt['aeva_admin_maintenance_checkfiles_found'] = '%s fichier(s) superflu(s) trouvé(s), consommant %s ko d\'espace supplémentaire. <a href="%s">Cliquez ici</a> pour le(s) supprimer.';
$txt['aeva_admin_maintenance_checkorphans_done'] = 'Les fichiers orphelins suivants ont été supprimés, pour un total de %s fichiers&nbsp;:';
$txt['aeva_admin_maintenance_checkorphans_no_files'] = 'Pas de fichiers orphelins trouvés';
$txt['aeva_admin_maintenance_clear_pending'] = 'Ce script est toujours actif. %s éléments sur %s sont terminés pour le moment.<br /><br /><a href="%s">Veuillez cliquer ici pour continuer</a>. Assurez-vous d\'avoir attendu 1 à 2 secondes afin d\'éviter les surcharges.';
$txt['aeva_admin_maintenance_clear_done'] = 'Tous les fichiers ont été renommés avec succès.';
$txt['aeva_admin_installed_on'] = 'Installé le';
$txt['aeva_admin_ffmpeg'] = ' FFMPEG';
$txt['aeva_admin_smf_ver'] = 'Version de SMF';
$txt['aeva_admin_php_ver'] = 'Version de PHP';
$txt['aeva_admin_about_header'] = 'Informations sur le serveur et ses modules installés';
$txt['aeva_admin_credits_thanks'] = 'Ceux qui ont rendu Aeva Media possible&nbsp;!';
$txt['aeva_admin_credits'] = 'Crédits';
$txt['aeva_admin_thanks'] = 'Remerciements';
$txt['aeva_admin_about_modd'] = 'Modérateurs et gérants du module';
$txt['aeva_admin_managers'] = 'Gérants';
$txt['aeva_admin_moderators'] = 'Modérateurs';
$txt['aeva_admin_icon_edit_subtext'] = 'Si vous désirez envoyer une icône, l\'ancienne sera écrasée. Laissez vide pour conserver l\'ancienne.';
$txt['aeva_admin_bans_mems_empty'] = 'Aucun membre n\'a été spécifié';
$txt['aeva_admin_expires_on_help'] = 'Doit être indiqué en &quot;jours&quot;, à partir de maintenant';
$txt['aeva_admin_modlog_desc'] = 'Le journal de modération vous propose la liste de toutes les actions de modération effectuées sur la galerie. N\'oubliez pas qu\'une fois effacées, les données du journal ne sont plus récupérables.';
$txt['aeva_admin_ftp_desc'] = 'Cette section vous permet d\'importer des éléments vers la galerie via un dossier distant sur le serveur. Cela permet notamment de mettre en place des fichiers plus gros que ne l\'autoriserait PHP pour un envoi classique.';
$txt['aeva_admin_ftp_help'] = 'Voici la liste des fichiers dans le dossier {Data_dir}/ftp. Merci de choisir l\'album de destination pour chaque dossier.';
$txt['aeva_admin_ftp_halted'] = 'Importation mise en pause pour éviter une surcharge serveur, %s importés sur %s. Le processus va reprendre automatiquement.';
$txt['aeva_admin_perms_desc'] = 'Cette section vous permet de gérer les différents profils de permissions, destinés à gérer les autorisations sur les albums.';
$txt['aeva_admin_prof_del_switch_help'] = 'Si vous désirez supprimer un profil utilisé par un ou plusieurs albums, vous devrez attribuer un autre profil aux albums en question.';
$txt['aeva_admin_quotas_desc'] = 'D\'ici, vous pouvez gérer les profils de quotas des groupes de membres. Oui, ça fait peur rien qu\'à le prononcer, ça.';
$txt['aeva_admin_safe_mode'] = 'Le Safe Mode de PHP est activé. Il peut causer des conflits avec Aeva Media. Merci de le <span style="color: red">désactiver</span> ou de lire la documentation dans le fichier MGallerySafeMode.php !';
$txt['aeva_admin_safe_mode_none'] = 'Le Safe Mode de PHP est désactivé, il ne devrait donc pas créer de conflit avec Aeva Media.';
$txt['aeva_admin_perms_warning'] = '<strong>Attention</strong>, les permissions générales d\'accès à Aeva Media sont à régler, groupe de membre par groupe de membre, dans <a href="%s">l\'administration classique</a>.';

// Exif strings
$txt['aeva_exif'] = 'Exif';
$txt['aeva_imagemagick'] = 'ImageMagick';
$txt['aeva_gd2'] = 'GD2';
$txt['aeva_MW'] = 'MagickWand';
$txt['aeva_imagick'] = 'IMagick';
$txt['aeva_exif_duration'] = 'Durée';
$txt['aeva_exif_bit_rate'] = 'Débit';
$txt['aeva_exif_frame_count'] = 'Nombre d\'images';
$txt['aeva_exif_audio_codec'] = 'Codec audio';
$txt['aeva_exif_video_codec'] = 'Codec vidéo';
$txt['aeva_exif_copyright'] = 'Copyright';
$txt['aeva_exif_make'] = 'Marque';
$txt['aeva_exif_model'] = 'Modèle';
$txt['aeva_exif_yres'] = 'Résolution-Y';
$txt['aeva_exif_xres'] = 'Résolution-X';
$txt['aeva_exif_resunit'] = 'Unité de résolution';
$txt['aeva_exif_datetime'] = 'Date';
$txt['aeva_exif_flash'] = 'Flash';
$txt['aeva_exif_focal_length'] = 'Longueur de focale';
$txt['aeva_exif_orientation'] = 'Orientation';
$txt['aeva_exif_xposuretime'] = 'Temps d\'exposition';
$txt['aeva_exif_not_available'] = 'Pas de données';
$txt['aeva_exif_entries'] = 'Voir les données';
$txt['aeva_exif_fnumber'] = 'Nombre F';
$txt['aeva_exif_iso'] = 'Valeur ISO';
$txt['aeva_exif_meteringMode'] = 'Mode de mesure';
$txt['aeva_exif_digitalZoom'] = 'Zoom numérique';
$txt['aeva_exif_contrast'] = 'Contraste';
$txt['aeva_exif_sharpness'] = 'Piqué';
$txt['aeva_exif_focusType'] = 'Type de focus';
$txt['aeva_exif_exifVersion'] = 'Version Exif';

// ModCP
$txt['aeva_modcp'] = 'Modération';
$txt['aeva_modcp_desc'] = 'Le centre de modération d\'Aeva Media vous permet de gérer les soumissions et rapports envoyés par les utilisateurs, et de consulter les journaux.';

// Per-album Permissions
$txt['permissionname_aeva_download_item'] = 'Télécharger des éléments';
$txt['permissionname_aeva_add_videos'] = 'Ajouter des fichiers vidéo';
$txt['permissionname_aeva_add_audios'] = 'Ajouter des fichiers audio';
$txt['permissionname_aeva_add_docs'] = 'Ajouter des documents';
$txt['permissionname_aeva_add_embeds'] = 'Ajouter des fichiers intégrés';
$txt['permissionname_aeva_add_images'] = 'Ajouter des images';
$txt['permissionname_aeva_rate_items'] = 'Donner des notes aux éléments';
$txt['permissionname_aeva_edit_own_com'] = 'Modifier ses commentaires';
$txt['permissionname_aeva_report_com'] = 'Signaler des commentaires';
$txt['permissionname_aeva_edit_own_item'] = 'Modifier ses éléments';
$txt['permissionname_aeva_comment'] = 'Commenter des éléments';
$txt['permissionname_aeva_report_item'] = 'Signaler des éléments';
$txt['permissionname_aeva_auto_approve_com'] = 'Auto-approuver ses commentaires';
$txt['permissionname_aeva_auto_approve_item'] = 'Auto-approuver ses uploads';
$txt['permissionname_aeva_multi_upload'] = 'Envoyer des fichiers en masse';
$txt['permissionname_aeva_whoratedwhat'] = 'Voir qui a voté quoi';
$txt['permissionname_aeva_multi_download'] = 'Télécharger des albums zippés';

// Custom fields
$txt['aeva_cf_invalid'] = 'Valeur invalide pour %s';
$txt['aeva_cf_empty'] = 'Le champ %s a été laissé vide';
$txt['aeva_cf_bbc'] = 'Ce champ peut utiliser du BBCode';
$txt['aeva_cf_required'] = 'Ce champ est requis';
$txt['aeva_cf_desc'] = 'D\'ici vous pouvez gérer les champs personnels';
$txt['aeva_cf'] = 'Champs personnels';
$txt['aeva_admin_labels_fields'] = 'Champs personnels';
$txt['aeva_cf_name'] = 'Nom du champ';
$txt['aeva_cf_type'] = 'Type de champ';
$txt['aeva_cf_add'] = 'Créer un champ';
$txt['aeva_cf_req'] = 'Requis';
$txt['aeva_cf_searchable'] = 'Recherchable';
$txt['aeva_cf_bbcode'] = 'BBC';
$txt['aeva_cf_editing'] = 'Ajouter/modifier un champ personnel';
$txt['aeva_cf_text'] = 'Texte';
$txt['aeva_cf_radio'] = 'Boutons radio';
$txt['aeva_cf_checkbox'] = 'Cases à cocher';
$txt['aeva_cf_textbox'] = 'Champ texte';
$txt['aeva_cf_select'] = 'Liste déroulante';
$txt['aeva_cf_options'] = 'Options du champ';
$txt['aeva_cf_options_stext'] = 'Ajouter des options pour les champs - valable uniquement pour les types Cases à cocher, Liste déroulante ou Boutons radio. Séparez les choix par des virgules (,)';

// Who's online strings
$txt['aeva_wo_home'] = 'Consulte l\'<a href="' . $scripturl . '?action=media">accueil</a> de la galerie';
$txt['aeva_wo_admin'] = 'Administre la galerie';
$txt['aeva_wo_unseen'] = 'Consulte les éléments non visités dans la galerie';
$txt['aeva_wo_search'] = 'Fait une recherche dans la galerie';
$txt['aeva_wo_item'] = 'Consulte &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_album'] = 'Consulte l\'album &quot;<a href="'.$scripturl.'?action=media;sa=album;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_add'] = 'Ajoute un élément à l\'album &quot;<a href="'.$scripturl.'?action=media;sa=album;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_edit'] = 'Modifie &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_comment'] = 'Commente &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_reporting'] = 'Signale &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; dans la galerie';
$txt['aeva_wo_stats'] = 'Consulte les statistiques de la galerie';
$txt['aeva_wo_vua'] = 'Consulte le panneau de contrôle d\'un album dans la galerie';
$txt['aeva_wo_ua'] = 'Consulte l\'accueil d\'un album dans la galerie';
$txt['aeva_wo_unknown'] = 'Effectue une action inconnue dans la galerie';
$txt['aeva_wo_hidden'] = 'Rôde quelque part dans la galerie, à un endroit insondable...';

// Help popup for the SMG tag...
$txt['aeva_smg_tag'] = '
	<h1>Le tag [smg] et autres joyeusetés.</h1>
	Un exemple en situation :
	<br />
	<br /><b>[smg id=123 type=preview align=center width=400 caption="Hello, world!"]</b>
	<br />Ce code affichera dans vos messages une image de taille intermédiaire (aperçu), alignée au centre, redimensionnée à 400 pixels de large, et accompagnée d\'un texte descriptif.
	Tous les paramètres sont facultatifs, seul l\'identifiant de l\'élément (id=123) est obligatoire.
	<br />
	<br /><b>[smg id=1 type=album]</b>
	<br />Ce code montrera une série de vignettes de type box (voir plus bas) appartenant à l\'album numéro 1, reproduisant plus ou moins le visuel de la page web de l\'album en question.
	<br /><br />
	<b>Valeurs possibles :</b>
	<br />- type=<i>normal, box, link, preview, full, album</i>
	<br />- align=<i>none, left, center, right</i>
	<br />- width=<i>123</i> (en pixels)
	<br />- caption=<i>&quot;Texte descriptif&quot;</i> ou caption=<i>EnUnMot</i>
	<br /><br />
	<b>id</b>
	<ul class="normallist">
		<li>Tous les éléments sont identifiés par un numéro dédié que vous pouvez voir dans leur adresse. Indiquez-le ici. C\'est le seul paramètre obligatoire. Je sais, c\'est moche. C\'est la vie.
		Mais faites pas cette tête, vous pouvez quand même spécifier plusieurs éléments en les séparant par une virgule, comme dans "[smg id=1,2,3 type=album]".</li>
	</ul>
	<br />
	<b>type</b>
	<ul class="normallist">
		<li><b>normal</b> (défaut, sauf si configuré différemment) - afficher la vignette. Cliquez dessus pour voir son aperçu.</li>
		<li><b>av</b> - afficher la vidéo ou le fichier audio dans le lecteur adéquat. Si vous ne précisez pas ce paramètre, la vignette habituelle sera affichée, mais en cliquant dessus, c\'est le fichier complet qui sera chargé, brut. Pas classe, pas classe du tout.</li>
		<li><b>box</b> - afficher la vignette complète, avec tous ses détails, comme sur les pages galerie d\'Aeva Media. Cliquez sur la vignette pour aller vers la page consacrée à l\'élément.</li>
		<li><b>link</b> - afficher la vignette, mais le texte descriptif devient interactif. Cliquez dessus pour aller vers la page consacrée à l\'élément. Si le paramètre caption est vide, un texte par défaut sera montré à la place.</li>
		<li><b>preview</b> (peut être choisi par défaut si configuré) - afficher l\'aperçu de l\'image (à mi-chemin entre la vignette et l\'image complète).</li>
		<li><b>full</b> (peut être choisi par défaut si configuré) - afficher l\'image entière. N\'oubliez pas de régler le paramètre width !</li>
		<li><b>album</b> - afficher les dernières vignettes de l\'album identifié par son ID. Elles seront présentées sous la forme <b>box</b>.</li>
	</ul>
	<br />
	<b>align</b>
	<ul class="normallist">
		<li><b>none</b> (défaut) - alignement normal. Les vignettes environnantes sont repoussées à la ligne suivante ou précédente.</li>
		<li><b>left</b> - aligner la vignette à gauche. Utilisez plusieurs tags [smg] alignés ainsi pour montrer les vignettes côte-à-côte.</li>
		<li><b>center</b> - aligner la vignette au centre. Pour afficher une vignette à gauche, une au milieu et une à droite, insérez-les dans cet ordre : [smg align=left][smg align=right][smg align=center]</li>
		<li><b>right</b> - aligner la vignette à droite. Même remarque que pour <i>left</i>. Rompez.</li>
	</ul>
	<br />
	<b>width</b>
	<ul class="normallist">
		<li>Utilisez ce paramètre pour forcer la largeur d\'une vignette à la dimension désirée. Indiquez un nombre supérieur à zéro.</li>
		<li>Réglez le paramètre <i>type</i> selon vos besoins. Ainsi, si vos vignettes ont pour largeur par défaut 120 pixels, et vos aperçus 500 pixels, utilisez [smg type=preview] si vous forcez une largeur supérieure à 300 pixels, pour éviter un effet de flou trop visible.</li>
	</ul>
	<br />
	<b>caption</b>
	<ul class="normallist">
		<li>Affiche un texte descriptif sous la vignette. Si le type est défini à <i>link</i>, le texte sera cliquable et vous mènera à la page consacrée à l\'élément.</li>
		<li>Entrez ce que vous voulez. Si votre texte contient des espaces ou des crochets, assurez-vous de l\'entourer de &quot;guillemets&quot;. Sinon, ça fait tout n\'importe quoi, et c\'est encore Bibi qui doit s\'y coller pour faire le ménage.</li>
	</ul>';

$txt['aeva_permissions_help'] = 'D\'ici vous pouvez ajouter, modifier ou supprimer les profils de permissions. Les profils peuvent être assignés à un ou plusieurs albums, et les albums en question suivront les permissions concernées.';
$txt['aeva_permissions_undeletable'] = 'Vous ne pouvez pas supprimer ce profil, car c\'est un profil par défaut.';

?>