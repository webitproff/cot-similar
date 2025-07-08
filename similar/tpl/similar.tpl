<!-- BEGIN: MAIN -->
<div class="col-12">
    <h4 class="mb-3">{PHP.L.Similar_pages}</h4>
    <div class="list-group mb-3">
        <!-- BEGIN: SIMILAR_ROW -->
        <div class="list-group-item list-group-item-action">
            <div class="align-items-center">
                <div class="col-12">
                    <a href="{SIMILAR_ROW_URL}" class="fw-bold text-decoration-none">{SIMILAR_ROW_TITLE}</a>
                    <div class="text-muted small">
                        {SIMILAR_ROW_NUMBER} {SIMILAR_ROW_TEXT_CUT_STRIP}
                    </div>					
                    <div class="text-muted small">
                        {SIMILAR_ROW_CAT_PATH_SHORT} &bull; {SIMILAR_ROW_CREATED} {SIMILAR_ROW_OWNER}
                    </div>
                </div>
            </div>
        </div>
        <!-- END: SIMILAR_ROW -->
    </div>
</div>

<!-- END: MAIN -->

<!-- BEGIN: NOTFOUND -->
<div class="col-12">
    <div class="alert alert-info" role="alert">
        {PHP.L.Similar_notfound}
    </div>
</div>
<!-- END: NOTFOUND -->