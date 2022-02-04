<div class="nav">
    <div class="STEM_OVERFLOW container">
        <ul>
            <li><a href="#" onClick="DRA_SEARCH_TOGGLE()">Search</a></li>
            <li><a href="home.php" id="selected">Featured</a></li>
            <?php 
                echo JSP_DISPLAY_ILIST(DRA_ENUMS_SWISS());
            ?>             
            <li><a href="#">More <span id="spanner">&rsaquo;</span></a></li>
        </ul>
    </div>
</div>

<div class="search STEM_OVERFLOW" <?php echo DRA_SEARCH_TOGGLE(); ?>>
    <div class="container">
            <?php echo JSP_FORMS_SEARCH('Search for insights like vehicle traffic along your route after 17:00'); ?>
            <div class="text-shadow" id="cancel" onClick="DRA_SEARCH_CLEAR()" title="Clear Search">x</div>
    </div>
</div>