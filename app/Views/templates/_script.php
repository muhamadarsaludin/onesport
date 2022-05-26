<!-- JQUERY -->
<script src="<?= base_url('js/jquery.min.js'); ?>"></script>
<!-- JQUERY Redirect-->
<script src="<?= base_url('js/jquery.redirect.js'); ?>"></script>
<!-- Bootstrap -->
<script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<!-- JQUERY Easing -->
<script src="<?= base_url('js/jquery.easing.min.js'); ?>"></script>
<!-- SB ADMIN 2 -->
<script src="<?= base_url('js/sb-admin-2.min.js'); ?>"></script>
<!-- SWEETALERT 2 -->
<script src="<?= base_url('js/sweetalert2.all.min.js'); ?>"></script>
<!-- SWIPER -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- SLICK -->
<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> -->
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- TINYMCE -->
<script src="https://cdn.tiny.cloud/1/gpe91r6ssffac21qy6khpp92qa4cxrxkjmhawlmdb63l65ho/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- MOMENT.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<!-- DATETIEM PICKER -->
<script src="<?= base_url('js/bootstrap-datetimepicker.js'); ?>"></script>
<!-- JQUERY -->
<script src="<?= base_url('js/jquery.dataTables.min.js'); ?>"></script>
<!-- DATATABLE -->
<script src="<?= base_url('js/dataTables.bootstrap4.min.js'); ?>"></script>
<!-- Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-QD_c2mAionu-LIuk"></script>
<!-- ====================MAIN SCRIPT====================== -->
<script src="<?= base_url('js/script.js'); ?>"></script>


<script>

    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(position =>{
            localCoord = position.coords;
            objLocalCoord = {
                lat: localCoord.latitude,
                lng: localCoord.longitude
            }
            
            let platform = new H.service.Platform({
                'apikey': 'k0uvKr3dsfHYgNXoU1oXBZaHrCRzIT-drjCNJr9JZas'
            });
            let defaultLayers = platform.createDefaultLayers();

            // Instantiate (and display) a map object:
            let map = new H.Map(
                document.getElementById('mapContainer'),
                defaultLayers.vector.normal.map,
                {
                    zoom: 13,
                    center: objLocalCoord,
                    pixelRation: window.devicePixelRatio || 1
                });
                window.addEventListener('resize', () => map.getViewPort().resize())
            
            let ui = H.ui.UI.createDefault(map, defaultLayers);
            let mapEvents = new H.mapevents.MapEvents(map);
            let behavior = new H.mapevents.Behavior(mapEvents);
            
            // Draggable marker function
            function addDragableMarker(map,behavior) {
                let inputLat = document.getElementById('lat');
                let inputLng = document.getElementById('lng');
                if (inputLat.value !='' && inputLng.value!=''){
                    objLocalCoord = {
                        lat: inputLat.value,
                        lng: inputLng.value
                    }
                }
                let marker = new H.map.Marker(objLocalCoord,{
                    volatility: true
                })
                marker.draggable = true
                map.addObject(marker)
                
                map.addEventListener('dragstart', function(ev){
                    let target = ev.target,
                        pointer = ev.currentPointer;
                    if (target instanceof H.map.Marker){
                        let targetPosition = map.geoToScreen(target.getGeometry());
                        target['offset']= new H.math.Point(
                            pointer.viewportX - targetPosition.x, pointer.viewportY - targetPosition.y
                        );
                        behavior.disable();
                    }
                }, false);

                map.addEventListener('drag', function(ev){
                    let target = ev.target,
                        pointer = ev.currentPointer
                    if(target instanceof H.map.Marker){
                        target.setGeometry(
                            map.screenToGeo(
                                pointer.viewportX - target['offset'].x, pointer.viewportY - target['offset'].y
                            )
                        );
                    }
                }, false);

                map.addEventListener('dragend', function(ev){
                    let target = ev.target;
                    if(target instanceof H.map.Marker){
                        behavior.enable();
                        let resultCoord = map.screenToGeo(
                            ev.currentPointer.viewportX,
                            ev.currentPointer.viewportY
                        );
                        inputLat.value = resultCoord.lat;
                        inputLng.value = resultCoord.lng;
                    }
                }, false)


            }
            addDragableMarker(map, behavior);
        })  
    }else{
        console.error("Geolocation is not supported by this browser!");
    }

    

   

</script>

