/*
 * @file Jwplayer plugin for CKEditor
 * Copyright (C) 2014 Tan Dung Phan
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 */

CKEDITOR.dialog.add('jwplayer', function (editor){    
    CKEDITOR.scriptLoader.load([nv_base_siteurl + 'assets/images/jwplayer/jwplayer.js']);
    
    function UpdatePreview(){
        var fileUrl = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'video_url').getValue();
        var imageUrl = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'preview_url').getValue();
        var auto = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'auto').getValue();
        var selectskin = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'skin').getValue();
        
        jwplayer("_video_preview").setup({
            file: fileUrl,
            image: imageUrl,
            width: 280,
            height: 175,
            autostart: auto,
            skin: {name: selectskin}
        });        
    }

    function ReturnPlayer(){
        var fileUrl = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'video_url').getValue();
        var imageUrl = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'preview_url').getValue();
        var width = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'width').getValue();
        var height = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'height').getValue();
        var auto = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'auto').getValue();
        var selectskin = CKEDITOR.dialog.getCurrent().getContentElement('tab1', 'skin').getValue();
        
        if(width == 0 && height == 0){
            width = 490;
            height = 300
        }
        
        var JWEmbem = '<div style="text-align:center;margin:0 auto;width:' + width + 'px;height:' + height + 'px;background:#dadada;"';
        
        JWEmbem += ' data-width="' + width + '"';
        JWEmbem += ' data-height="' + height + '"';
        JWEmbem += ' data-auto="' + auto + '"';
        JWEmbem += ' data-skin="' + selectskin + '"';
        
        if(imageUrl != ''){
            JWEmbem += ' data-image="' + imageUrl + '"';
        }
        
        JWEmbem += ' data-url="' + fileUrl + '"';
        JWEmbem += ' class="jwplayer-html5-item"';
        JWEmbem += '><div>' + editor.lang.jwplayer.videoGoesArea + '</div></div><br />';
        
        return JWEmbem;
    }

    return {
        title: editor.lang.jwplayer.dialogTitle,
        minWidth: 450,
        minHeight: 230,
        contents: [{
            id: 'tab1',
            label: '',
            title: '',
            expand: true,
            padding: 0,
            elements: [{
                type: 'vbox',
                widths: ['280px', '30px'],
                align: 'left',
                children: [{
                    type: 'hbox',
                    widths: ['280px', '30px'],
                    align: 'left',
                    children: [{
                        type: 'text',
                        required: true,
                        validate: CKEDITOR.dialog.validate.notEmpty(editor.lang.flash.validateSrc),
                        id: 'video_url',
                        label: editor.lang.jwplayer.videoLink,
                        onChange: UpdatePreview,
                    }, {
                        type: 'button',
                        id: 'browse',
                        filebrowser: 'tab1:video_url',
                        label: editor.lang.common.browseServer,
                        style: 'display:inline-block;margin-top:14px;',
                    }]
                }, {
                    type: 'hbox',
                    widths: ['280px', '30px'],
                    align: 'left',
                    children: [{
                        type: 'text',
                        id: 'preview_url',
                        label: editor.lang.jwplayer.previewImage,
                        onChange: UpdatePreview,
                    }, {
                        type: 'button',
                        id: 'browse',
                        filebrowser: 'tab1:preview_url',
                        label: editor.lang.common.browseServer,
                        style: 'display:inline-block;margin-top:14px;',
                    }]
                }, {
                    type: 'hbox',
                    widths: ['280px', '10px'],
                    align: 'left',
                    children: [{
                        type: 'vbox',
                        widths: ['280px', '10px'],
                        align: 'left',
                        children: [{
                            type: 'select',
                            id: 'skin',
                            'default': 'default',
                            label: editor.lang.jwplayer.skin,
                            items: [
                                [editor.lang.jwplayer.skinDefault, 'default'],
                                ["beelden", 'beelden'],
                                ["bekle", 'bekle'],
                                ["five", 'five'],
                                ["glow", 'glow'],
                                ["roundster", 'roundster'],
                                ["six", 'six'],
                                ["stormtrooper", 'stormtrooper'],
                                ["vapor", 'vapor'],
                            ],
                            onChange: UpdatePreview,
                        }, {
                            type: 'text',
                            id: 'width',
                            'default': 500,
                            style: 'width:95px',
                            label: editor.lang.common.width,
                            validate: CKEDITOR.dialog.validate.integer(editor.lang.common.invalidWidth),
                            onChange: UpdatePreview,
                        }, {
                            type: 'text',
                            id: 'height',
                            'default': 310,
                            style: 'width:95px',
                            label: editor.lang.common.height,
                            validate: CKEDITOR.dialog.validate.integer(editor.lang.common.invalidHeight),
                            onChange: UpdatePreview,
                        }, {
                            type: 'checkbox',
                            id: 'auto',
                            'default': false,
                            label: editor.lang.flash.chkPlay,
                            onChange: UpdatePreview,
                        }]
                    }, {
                        type: 'vbox',
                        widths: ['280px', '10px'],
                        align: 'left',
                        children: [{
                            type: 'html',
                            id: 'preview',
                            html: '<div id="_video_preview" style="width:280px;height:175px;background:#333"></div><br>' + editor.lang.jwplayer.author + ' :Tan Dung Phan [phantandung92@gmail.com]'
                        }]
                    }]
                }]
            }]
        }],
        buttons: [CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton],
        onOk: function (){
            jwplayer("_video_preview").stop();
            editor.setData(editor.getData() + ReturnPlayer());
        }
    }
});