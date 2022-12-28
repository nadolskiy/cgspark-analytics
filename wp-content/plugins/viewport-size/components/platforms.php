<div class="devices">
            
    <!-- Top 3 platform -->
    <div class="top-3-platforms" id="top-3-platforms">
    </div><!-- .devices-title-row -->

    <!-- Analytics -->
    <div class="platform-graph-container">

        <!-- By months -->
        <div class="platform-big-graph-container box-container"  data-aos="fade-right" data-aos-delay="600">
            <p class="box--sub-title">Platform analytics for <span id="currentYear"></span> year by months</p>
            <canvas id="graph-platform-by-months"></canvas>
        </div>

        <!-- By segment -->
        <div class="platform-small-graph-container box-container"  data-aos="fade-right" data-aos-delay="750">
            <p class="box--sub-title"><span id="currentYear2"></span> year platform use</p>
            <canvas id="graph-platform-by-segment"></canvas>
        </div>
    </div> <!-- .platform-graph-container -->

    <!-- All Platforms -->
    <div class="platform-data-container box-container" data-aos="fade-right">
        <h2 class="section-title" data-aos="fade-right">All Platforms</h2>

        <!-- Title -->
        <div class="platform-data platform-data-title">
            <div class="platform-column">Platform</div>
            <div class="platform-column">Trends</div>
            <div class="platform-column">This Month</div>
            <div class="platform-column">This Year</div>
            <div class="platform-column">All period</div>
            <div class="platform-column">Piece</div>
        </div><!-- .platform-data-title-->

        <!-- List -->
        <div id="platform-data-list" class="platform-data-result">    
        </div><!-- .platform-data-list -->

    </div><!-- .platform-data-container -->

</div><!-- .devices -->