(function () {
  CKEDITOR.plugins.add('imgur', {
    lang: ['zh', 'en', 'vi'],
    init: function (editor) {
      ClientID = editor.config.imgurClientID
      if (!ClientID) { alert(editor.lang.imgur.ClientIDMissing) }
      var count = 0
      var $placeholder = $('<div></div>').css({
        position: 'absolute',
        bottom: 0,
        left: 0,
        right: 0,
        backgroundColor: 'rgba(20, 20, 20, .6)',
        padding: 5,
        color: '#fff'
      }).hide()
      function getToken () {
        var settings = {
          'async': true,
          'crossDomain': true,
          'url': 'https://api.imgur.com/oauth2/token',
          'method': 'POST',
          'headers': {
            'content-type': 'application/x-www-form-urlencoded'
          },
          'data': {
            'refresh_token': editor.config.imgurRefreshToken,
            'client_id': editor.config.imgurClientID,
            'client_secret': editor.config.imgurClientSecret,
            'grant_type': 'refresh_token'
          }
        }
        $.ajax(settings).done(function (response) {
          localStorage.setItem('imgur_access_token', response.access_token)
        })
      }
      editor.on('pluginsLoaded', function () {
        getToken()
      })
      editor.on('instanceReady', function () {
        var $w = $(editor.window.getFrame().$).parent()
        $w.css({
          position: 'relative'
        })
        $placeholder.appendTo($w)
      })
      editor.ui.addButton('Imgur', {
        label: editor.lang.imgur.label,
        toolbar: 'insert',
        command: 'imgur',
        icon: this.path + 'images/icon.png'
      })
      editor.addCommand('imgur', {
        exec: function () {
          $input = $('<input type="file" multiple/>')
          $input.on('change', function (e) {
            files = e.target.files
            $.each(files, function (i, file) {
              count++
              form = new FormData()
              form.append('image', file)
              var accessToken = localStorage.getItem('imgur_access_token') || ''
              if (accessToken) {
                $.ajax({
                  url: 'https://api.imgur.com/3/image',
                  headers: {
                    Authorization: 'Bearer ' + accessToken
                  },
                  type: 'POST',
                  data: form,
                  cache: false,
                  contentType: false,
                  processData: false
                }).always(function (jqXHR) {
                  count--
                  $placeholder.text(count + editor.lang.imgur.uploading).toggle(count != 0)
                  if (jqXHR.status != 200) {
                    res = $.parseJSON(jqXHR.responseText)
                  } else {
                    res = jqXHR
                  }
                  if (res.data.error) {
                    alert(editor.lang.imgur.failToUpload + res.data.error)
                  } else {
                    let httpLink = res.data.link.replace(/^https?/i, 'https')
                    content = `<img src= '${httpLink}'/>`
                    var element = CKEDITOR.dom.element.createFromHtml(content)
                    editor.insertElement(element)
                  }
                })
              } else {
                alert(editor.lang.imgur.failToGetToken)
              }
            })
            $placeholder.text(count + editor.lang.imgur.uploading).fadeIn()
          })
          $input.click()
        }
      })
      editor.on('drop', function (evt) {
        var data = evt.data,
          // Prevent XSS attacks
          tempDoc = document.implementation.createHTMLDocument(''),
          temp = new CKEDITOR.dom.element(tempDoc.body),
          imgs, img, i
        if (data && data.dataValue && data.dataValue.startsWith('<img')) {
          count++
          var dataURL = $(data.dataValue).attr('src')
          dataURL = dataURL.replace(/^data:image\/(png|jpg);base64,/, '')
          var form = new FormData()
          form.append('image', dataURL)
          var accessToken = localStorage.getItem('imgur_access_token') || ''
          if (accessToken) {
            $.ajax({
              url: 'https://api.imgur.com/3/image',
              headers: {
                Authorization: 'Bearer ' + accessToken
              },
              type: 'POST',
              data: form,
              cache: false,
              contentType: false,
              processData: false
            }).always(function (jqXHR) {
              count--
              $placeholder.text(count + editor.lang.imgur.uploading).toggle(count != 0)
              if (jqXHR.status != 200) {
                res = $.parseJSON(jqXHR.responseText)
              } else {
                res = jqXHR
              }
              if (res.data.error) {
                alert(editor.lang.imgur.failToUpload + res.data.error)
              } else {
                let httpLink = res.data.link.replace(/^https?/i, 'https')
                content = `<img src= '${httpLink}'/>`
                var element = CKEDITOR.dom.element.createFromHtml(content)
                editor.insertElement(element)
              }
            })
          } else {
            alert(editor.lang.imgur.failToGetToken)
          }
          $placeholder.text(count + editor.lang.imgur.uploading).fadeIn()
          return false
        }
        for (i = 0; i < evt.data.dataTransfer.getFilesCount(); i++) {
          count++
          file = evt.data.dataTransfer.getFile(i)
          form = new FormData()
          form.append('image', file)
          var accessToken = localStorage.getItem('imgur_access_token') || ''
          if (accessToken) {
            $.ajax({
              url: 'https://api.imgur.com/3/image',
              headers: {
                Authorization: 'Bearer ' + accessToken
              },
              type: 'POST',
              data: form,
              cache: false,
              contentType: false,
              processData: false
            }).always(function (jqXHR) {
              count--
              $placeholder.text(count + editor.lang.imgur.uploading).toggle(count != 0)
              if (jqXHR.status != 200) {
                res = $.parseJSON(jqXHR.responseText)
              } else {
                res = jqXHR
              }
              if (res.data.error) {
                alert(editor.lang.imgur.failToUpload + res.data.error)
              } else {
                let httpLink = res.data.link.replace(/^https?/i, 'https')
                content = `<img src= '${httpLink}'/>`
                var element = CKEDITOR.dom.element.createFromHtml(content)
                editor.insertElement(element)
              }
            })
          } else {
            alert(editor.lang.imgur.failToGetToken)
          }
          $placeholder.text(count + editor.lang.imgur.uploading).fadeIn()
          return false
        }
        return true
      })
    }
  })
})();