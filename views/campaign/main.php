
<script src="<?= APP_URL; ?>/public_files/javascript/campaign.js"></script>

<div class="core">
    <div class="menu content-full">
        <div class="menu-item">
            <a href="<?= APP_URL; ?>/home">Home</a>
        </div>
        <div class="menu-item">
            Ad Sets
        </div>
        <div class="menu-item">
            Audiences
        </div>
        <div class="menu-right">
            Campaign
        </div>
    </div>
    
    <div class="content-full">
        <div class="menu content-full">
            <div class="menu-item">
                <div id="new-campaign">Create</div>
            </div>
            <div class="menu-item">
                <a href="<?= APP_URL; ?>/updateCampaign">Update</a>
            </div>
            <div class="menu-item">
                <div id="remove-campaign">Remove</div>
            </div>
            <div class="menu-item">
                <div id="sort-campaign-dialog">Sort</div>
            </div>
            <div class="menu-right">
                All Campaigns
            </div>
        </div>
        <div id="campaignList" class="content-full-body">
            Your Campaigns will appear here.
        </div>
        <script>MSDCampaign();</script>
    </div></div>