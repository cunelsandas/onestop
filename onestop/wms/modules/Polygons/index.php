
    <!-- NOTE: two libraries to load are comma-separated; otherwise last mention of the query string arg overwrites the previous -->
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&sensor=false&libraries=drawing,places"></script>
    <style type="text/css">
      #map{
        height: 100%;
      }
      #content {
       padding: 20px;
       height: 100%;
     }
      #panel {
        width: 200px;
        font-family: Arial, sans-serif;
        font-size: 13px;
        float: right;
        margin: 10px;
      }
      #color-palette {
        clear: both;
      }
      .color-button {
        width: 14px;
        height: 14px;
        font-size: 0;
        margin: 2px;
        float: left;
        cursor: pointer;
      }
      #delete-button {
        margin-top: 5px;
      }
    </style>

<?php

!empty($_GET['no'])?$no=$_GET['no']:null;
!empty($_GET['type'])?$type=$_GET['type']:null;

if($type=="addmoo"){
	include "add_moo.php";
}else {

if (isset($_POST["submit"]) != "") {

$sql = "INSERT INTO tb_map_tambon(id,tambon,lat,lng,department_id) VALUES ('','".$_POST["tambon"]."','".$_POST["lat"]."','".$_POST["lng"]."','xx')";
$rs = rsQuery($sql);

}
?>



    <script type="text/javascript">
      var drawingManager;
      var selectedShape;
      var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
      var selectedColor;
      var colorButtons = {};
      function clearSelection() {
        if (selectedShape) {
          if (typeof selectedShape.setEditable == 'function') {
            selectedShape.setEditable(false);
          }
          selectedShape = null;
        }
        curseldiv.innerHTML = "<b>cursel</b>:";
      }
      function updateCurSelText(shape) {
        posstr = "" + selectedShape.position;
        if (typeof selectedShape.position == 'object') {
          posstr = selectedShape.position.toUrlValue();
        }
        pathstr = "" + selectedShape.getPath;
        if (typeof selectedShape.getPath == 'function') {
          pathstr = "[ ";
          lat = "";
          lng = "";
          for (var i = 0; i < selectedShape.getPath().getLength(); i++) {
            // .toUrlValue(5) limits number of decimals, default is 6 but can do more
            if (i != selectedShape.getPath().getLength()-1) {
              lat += selectedShape.getPath().getAt(i).lat()+",";
              lng += selectedShape.getPath().getAt(i).lng()+",";
            }else {
              lat += selectedShape.getPath().getAt(i).lat();
              lng += selectedShape.getPath().getAt(i).lng();
            }
            pathstr += selectedShape.getPath().getAt(i).toUrlValue() + " , ";
          }
          pathstr += "]";
        }
        bndstr = "" + selectedShape.getBounds;
        cntstr = "" + selectedShape.getBounds;
        if (typeof selectedShape.getBounds == 'function') {
          var tmpbounds = selectedShape.getBounds();
          cntstr = "" + tmpbounds.getCenter().toUrlValue();
          bndstr = "[NE: " + tmpbounds.getNorthEast().toUrlValue() + " SW: " + tmpbounds.getSouthWest().toUrlValue() + "]";
        }
        cntrstr = "" + selectedShape.getCenter;
        if (typeof selectedShape.getCenter == 'function') {
          cntrstr = "" + selectedShape.getCenter().toUrlValue();
        }
        radstr = "" + selectedShape.getRadius;
        if (typeof selectedShape.getRadius == 'function') {
          radstr = "" + selectedShape.getRadius();
        }
        curseldiv.innerHTML = " <i>path</i>: " + pathstr + "; marker:"+posstr;
        document.getElementById("lat").value = lat;
        document.getElementById("lng").value = lng;
      }
      function setSelection(shape, isNotMarker) {
        clearSelection();
        selectedShape = shape;
        if (isNotMarker)
          shape.setEditable(true);
        selectColor(shape.get('fillColor') || shape.get('strokeColor'));
        updateCurSelText(shape);
      }
      function deleteSelectedShape() {
        if (selectedShape) {
          selectedShape.setMap(null);
        }
      }
      function selectColor(color) {
        selectedColor = color;
        for (var i = 0; i < colors.length; ++i) {
          var currColor = colors[i];
          colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
        }
        // Retrieves the current options from the drawing manager and replaces the
        // stroke or fill color as appropriate.
        var polylineOptions = drawingManager.get('polylineOptions');
        polylineOptions.strokeColor = color;
        drawingManager.set('polylineOptions', polylineOptions);
        var rectangleOptions = drawingManager.get('rectangleOptions');
        rectangleOptions.fillColor = color;
        drawingManager.set('rectangleOptions', rectangleOptions);
        var circleOptions = drawingManager.get('circleOptions');
        circleOptions.fillColor = color;
        drawingManager.set('circleOptions', circleOptions);
        var polygonOptions = drawingManager.get('polygonOptions');
        polygonOptions.fillColor = color;
        drawingManager.set('polygonOptions', polygonOptions);
      }
      function setSelectedShapeColor(color) {
        if (selectedShape) {
          if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
            selectedShape.set('strokeColor', color);
          } else {
            selectedShape.set('fillColor', color);
          }
        }
      }
      function makeColorButton(color) {
        var button = document.createElement('span');
        button.className = 'color-button';
        button.style.backgroundColor = color;
        google.maps.event.addDomListener(button, 'click', function() {
          selectColor(color);
          setSelectedShapeColor(color);
        });
        return button;
      }
       function buildColorPalette() {
         var colorPalette = document.getElementById('color-palette');
         for (var i = 0; i < colors.length; ++i) {
           var currColor = colors[i];
           var colorButton = makeColorButton(currColor);
           colorPalette.appendChild(colorButton);
           colorButtons[currColor] = colorButton;
         }
         selectColor(colors[0]);
       }
      /////////////////////////////////////
      var map; //= new google.maps.Map(document.getElementById('map'), {
      // these must have global refs too!:
      var placeMarkers = [];
      var input;
      var searchBox;
      var curposdiv;
      var curseldiv;
      function deletePlacesSearchResults() {
        for (var i = 0, marker; marker = placeMarkers[i]; i++) {
          marker.setMap(null);
        }
        placeMarkers = [];
        input.value = ''; // clear the box too
      }
      /////////////////////////////////////
      function initialize() {
        map = new google.maps.Map(document.getElementById('map'), { //var
          zoom: 15,//10,
          center: new google.maps.LatLng(18.78687983, 98.98621559),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: false,
          zoomControl: true
        });
        curposdiv = document.getElementById('curpos');
        curseldiv = document.getElementById('cursel');
        var polyOptions = {
          strokeWeight: 0,
          fillOpacity: 0.45,
          editable: true
        };
        // Creates a drawing manager attached to the map that allows the user to draw
        // markers, lines, and shapes.
        drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.POLYGON,
          markerOptions: {
            draggable: true,
            editable: true,
          },
          polylineOptions: {
            editable: true
          },
          rectangleOptions: polyOptions,
          circleOptions: polyOptions,
          polygonOptions: polyOptions,
          map: map
        });
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
          //~ if (e.type != google.maps.drawing.OverlayType.MARKER) {
            var isNotMarker = (e.type != google.maps.drawing.OverlayType.MARKER);
            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setDrawingMode(null);
            // Add an event listener that selects the newly-drawn shape when the user
            // mouses down on it.
            var newShape = e.overlay;
            newShape.type = e.type;
            google.maps.event.addListener(newShape, 'click', function() {
              setSelection(newShape, isNotMarker);
            });
            google.maps.event.addListener(newShape, 'drag', function() {
              updateCurSelText(newShape);
            });
            google.maps.event.addListener(newShape, 'dragend', function() {
              updateCurSelText(newShape);
            });
            setSelection(newShape, isNotMarker);
          //~ }// end if
        });
        // Clear the current selection when the drawing mode is changed, or when the
        // map is clicked.
        google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
        google.maps.event.addListener(map, 'click', clearSelection);
        google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
        buildColorPalette();
        //~ initSearch();
        // Create the search box and link it to the UI element.
         input = /** @type {HTMLInputElement} */( //var
            document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
        //
        var DelPlcButDiv = document.createElement('div');
        //~ DelPlcButDiv.style.color = 'rgb(25,25,25)'; // no effect?
        DelPlcButDiv.style.backgroundColor = '#fff';
        DelPlcButDiv.style.cursor = 'pointer';
        DelPlcButDiv.innerHTML = 'DEL';
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(DelPlcButDiv);
        google.maps.event.addDomListener(DelPlcButDiv, 'click', deletePlacesSearchResults);

        searchBox = new google.maps.places.SearchBox(document.getElementById('mapsearch'));

        google.maps.event.addListener(searchBox, 'places_changed',function () {
            var places = searchBox.getPlaces();

            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for(i=0;place=places[i];i++){
                console.log(places);
                bounds.extend(place.geometry.location);
                var item_lat = place.geometry.location.lat();
                var item_lng = place.geometry.location.lng();
            }

            map.fitBounds(bounds);
            map.setZoom(15);

        });

      }


      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

<div class="content" name="content">

    <div class="row"> <h1>ADD TAMBON.</h1> </div>

    <div id="panel">
      <div class="form-group">
          <label><b>ค้นหาพื้นที่:</b></label>
          <input class="form-control" type="text" name="mapsearch" id="mapsearch">
      </div>

      <form class="frm_map" name="frm_map" action="#" method="post">
      <div id="color-palette"></div>
      <div>
        <a type="button" class="btn btn-info" id="delete-button">Delete Selected Shape</a>
      </div>
    <div id="cursel"></div>

    <div class="form-group" style="margin-top: 15px">
    <label for="formGroupExampleInput">เขต:</label>
    <input id="tambon" name="tambon" type="text" class="form-control" id="formGroupExampleInput" placeholder="เขต,ตำบล,อำเภอ">
  </div>

<div id="cursel"></div>

  <div class="form-row">
    <div class="col">
      <input id="lat" name="lat" type="hidden" class="form-control" placeholder="Lat">
    </div>
  </div>

  <div class="form-row">
    <div class="col">
      <input id="lng" name="lng" type="hidden" class="form-control" placeholder="Lng">
    </div>
  </div>

    <div class="form-row" style="text-align: center; margin-top:15px;">
    <input class="btn btn-info" type="submit" name="submit" value="Submit"></input>
  </div>

  <div class="form-row" style="text-align: center; margin-top:15px;">
  <?php echo"<a class='btn btn-info' href=\"main.php?_mod=maps&_modid=61&type=addmoo \">add moo</a>";?>
  </div>

    </form>
    </div>

    <div style="width: 100%; height: 500px;" >
      <div id="map">A</div>
    </div>
</div>

<?php } ?>
