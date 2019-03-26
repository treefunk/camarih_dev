<div class="modal fade" id="viewDownloadModal" tabindex="-1" role="dialog" aria-labelledby="viewDownloadModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                    style="z-index:99">×</button>
                <h4 class="modal-title">More Details</h4>
                
            </div>
            <div class="modal-body">
                    <?php
                      $url = !$dummy_doc ? base_url() . $downloads_url . "/" . $package->package_download->id . "_" . $package->package_download->file_name : "https://doallmetals.betaprojex.com/test.docx"; 
                    ?>

                    <iframe width="860" height="850" src="https://docs.google.com/gview?url=<?=$url?>&embedded=true"></iframe>
            </div>
        </div>
    </div>
</div>