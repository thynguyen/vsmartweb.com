var degree = 18000,
    clicks = 10000;

var reload = '#results';

function getRotationDegrees(e) {
    var r = e.css("-webkit-transform") || e.css("-moz-transform") || e.css("-ms-transform") || e.css("-o-transform") || e.css("transform");
    if ("none" !== r) var s = r.split("(")[1].split(")")[0].split(","),
        n = s[0],
        t = s[1],
        a = Math.round(Math.atan2(t, n) * (180 / Math.PI));
    else a = 0;
    return a < 0 ? a + 360 : a
}
$(document).ready(function() {
    var data = {
        '1name': '1.jpg',
        '2name': '2.jpg',
        '3name': '3.jpg',
        '4name': '4.jpg',
        '5name': '5.jpg',
        '6name': '6.jpg',
        '7name': '7.jpg',
        '8name': '8.jpg',
        '9name': '9.jpg',
        '10name': '10.jpg',
    };

    var resultImages = {
        'name': 'image-in-result.jpg',
    }
    for (let i in data) {
        $('#inner-wheel').append(`
            <div class="sec">
                <img data-name="${i}" src="/images/spin/${data[i]}">
            </div>
        `);
    }
    let allItems = JSON.parse(localStorage.getItem('allItems')) ? JSON.parse(localStorage.getItem('allItems')) : [];
    if (allItems.length > 0) {
        for (let i in allItems) {
            $('#results').append(`
                  <tr>
                    <td><img class="img-fluid"data-name="${allItems[i].key}" src="/images/spin/${allItems[i].image}"></td>
                    <td>${allItems[i].key}</td>
                    <td>${allItems[i].name}</td>
                    <td><button class="delete" data-image="${allItems[i]}" data-key="${allItems[i].key}"><i class="fa fa-trash"></i></button></td>
                  </tr>
            `);
        }

        $("#inner-spin").css("background", "url(/images/spin/" + allItems[allItems.length - 1].image + ") center center no-repeat"), $("#spin").addClass("showing"), !1
    }
    $("#spin, #btnspin").click(function() {
        play();
        var e = degree * ++clicks + (Math.floor(360 * Math.random()) + 1),
            r = 360 - e % 360;
        $("#spin").removeClass("showing"), $("#inner-spin").css("background", ""), $("#inner-wheel").css({
            transform: "rotate(" + e + "deg)"
        }), setTimeout(function() {
            $("#wheel div.sec").each(function(e, s) {
                var n = getRotationDegrees($(s));
                if (0 === n && (n = 360), n - 20 < r && r <= n + 20) {
                    var t = $(s).children("img").attr("src");
                    let items = JSON.parse(localStorage.getItem('allItems')) ? JSON.parse(localStorage.getItem('allItems')) : [];
                    for (let i in data) {
                        if (data[i] == t.split('/')[3] && JSON.stringify(allItems).indexOf(JSON.stringify({
                            key: i,
                            image: data[i]
                        })) < 0) {
                            items.push({
                                key: i,
                                image: data[i],
                                name: $('#nameplayer').val()
                            });
                            Swal.fire({
                                title: `<strong>${i}! </strong>`,
                                imageUrl: `/images/spin/${data[i]}`,
                                imageWidth: 300,
                                animation: true
                            });
                            localStorage.setItem('allItems', JSON.stringify(items))
                        }
                    }

                    volume();
                    $("#inner-spin").css("background", "url(" + t + ") center center no-repeat"), $("#spin").addClass("showing"), !1
                }
            })
            let allItemsAfter = JSON.parse(localStorage.getItem('allItems')) ? JSON.parse(localStorage.getItem('allItems')) : [];
            if (allItemsAfter.length > 0) {
                $('#results').html('');
                for (let i in allItemsAfter) {
                    $('#results').append(`
                          <tr>
                            <td><img class="img-fluid"data-name="${allItemsAfter[i].key}" src="/images/spin/${allItemsAfter[i].image}"></td>
                            <td>${allItemsAfter[i].key}</td>
                            <td>${allItemsAfter[i].name}</td>
                            <td><button class="delete" data-key="${allItemsAfter[i].key}" data-image="${allItemsAfter[i]}"><i class="fa fa-trash"></i></button></td>
                          </tr>
                    `);
                }

                $("#inner-spin").css("background", "url(/images/spin/" + allItemsAfter[allItemsAfter.length - 1].image + ") center center no-repeat"), $("#spin").addClass("showing"), !1
            }
        }, 6000)
    })
    $('#results').on('click', '.delete', function () {
        if (confirm('Bạn muốn thực hiện thao tác này?')) {
            let key = $(this).data('key');
            let image = $(this).data('image');
            let allItems = JSON.parse(localStorage.getItem('allItems')) ? JSON.parse(localStorage.getItem('allItems')) : [];

            $.each(allItems, function (i, val) {
                if (val && val.key == key) {
                    allItems.splice(i, 1);
                }
            })

            $('#results').html('');
            for (let i in allItems) {
                $('#results').append(`
                      <tr>
                        <td><img class="img-fluid"data-name="${allItems[i].key}" src="/images/spin/${allItems[i].image}"></td>
                        <td>${allItems[i].key}</td>
                        <td>${allItems[i].name}</td>
                        <td><button class="delete" data-key="${allItems[i].key}" data-image="${allItems[i]}"><i class="fa fa-trash"></i></button></td>
                      </tr>
                `);
            }

            localStorage.setItem('allItems', JSON.stringify(allItems))
            $(reload).load(window.location.href + " "+reload+" > *");
            // location.reload();
        }
    })
    function play(){
       var audio = document.getElementById("audio");
       audio.currentTime=0;
       audio.volume = 1;
       audio.play();
    }

    function volume() {
       var audio = document.getElementById("audio");
       audio.volume = 0;
    }
});