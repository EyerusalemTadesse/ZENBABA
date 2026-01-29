<?php
include "includes/config.php";
?>

<style>
/* ===== STORIES PAGE ===== */
.stories-hero{
    background: linear-gradient(135deg, #14532d, #0a3d2e);
    color:#fff;
    padding:80px 30px;
    border-radius:22px;
    margin:40px auto 60px;
    max-width:1200px;
    text-align:center;
}
.stories-hero h1{
    font-size:48px;
    margin-bottom:18px;
    letter-spacing:0.5px;
}
.stories-hero p{
    font-size:20px;
    max-width:760px;
    margin:auto;
    opacity:0.95;
    line-height:1.6;
}

/* ===== STORY GRID ===== */
.stories-container{
    max-width:1200px;
    margin:auto;
    padding:0 20px 80px;
}
.story-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:35px;
}

/* ===== STORY CARD ===== */
.story-card{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 18px 40px rgba(0,0,0,0.08);
    transition:transform .35s, box-shadow .35s;
}
.story-card:hover{
    transform:translateY(-10px);
    box-shadow:0 28px 60px rgba(0,0,0,0.15);
}
.story-card img{
    width:100%;
    height:300px;
    object-fit:cover;
}
.story-content{
    padding:28px;
}
.story-content h3{
    font-size:24px;
    margin-bottom:10px;
    color:#14532d;
}
.story-role{
    font-size:14px;
    font-weight:600;
    color:#0a58ca;
    margin-bottom:14px;
}
.story-content p{
    font-size:16px;
    line-height:1.7;
    color:#444;
}

/* ===== QUOTE ===== */
.story-quote{
    margin-top:20px;
    padding-left:18px;
    border-left:4px solid #14532d;
    font-style:italic;
    color:#333;
}

/* ===== CTA ===== */
.stories-cta{
    margin:90px auto 0;
    text-align:center;
}
.stories-cta h2{
    font-size:34px;
    margin-bottom:15px;
}
.stories-cta p{
    font-size:18px;
    max-width:700px;
    margin:auto auto 30px;
}
.stories-cta a{
    display:inline-block;
    padding:16px 40px;
    background:linear-gradient(135deg,#14532d,#0a3d2e);
    color:#fff;
    border-radius:30px;
    text-decoration:none;
    font-weight:600;
    transition:transform .3s, box-shadow .3s;
}
.stories-cta a:hover{
    transform:scale(1.05);
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}
</style>

<div class="stories-hero">
    <h1>Stories of the Women Behind Zenbaba</h1>
    <p>
        Every product carries a story — of heritage, resilience, and women
        who transform tradition into opportunity.
    </p>
</div>

<div class="stories-container">

    <div class="story-grid">

        <!-- STORY 1 -->
        <div class="story-card">
            <img src="assets/images/woman1.jpg" alt="Aster – Mesob Weaver">
            <div class="story-content">
                <h3>Aster Tesfaye</h3>
                <div class="story-role">Mesob Weaver • Gurage</div>
                <p>
                    For over 25 years, Aster has preserved the ancient art of Mesob weaving,
                    a skill passed down through generations of women in her family.
                    What began as a household tradition is now her pathway to independence.
                </p>
                <div class="story-quote">
                    “Each Mesob carries the spirit of my mother and grandmother.”
                </div>
            </div>
        </div>

        <!-- STORY 2 -->
        <div class="story-card">
            <img src="assets/images/woman2.jpg" alt="Selam – Clay Artist">
            <div class="story-content">
                <h3>Selam Kebede</h3>
                <div class="story-role">Clay Artist • Amhara</div>
                <p>
                    Selam learned pottery by watching her grandmother mold clay beside a riverbank.
                    Today, her work blends ancient Ethiopian techniques with modern design,
                    creating functional art loved across the country.
                </p>
                <div class="story-quote">
                    “Clay remembers every hand that shapes it.”
                </div>
            </div>
        </div>

        <!-- STORY 3 -->
        <div class="story-card">
            <img src="assets/images/woman3.jpg" alt="Mimi – Textile Artist">
            <div class="story-content">
                <h3>Mimi Alemu</h3>
                <div class="story-role">Textile Artist • Addis Ababa</div>
                <p>
                    Mimi turns cotton and natural dyes into bold expressions of Ethiopian identity.
                    Through Zenbaba Market, her fabrics travel far beyond local markets,
                    telling stories of culture and confidence.
                </p>
                <div class="story-quote">
                    “When women earn, families grow stronger.”
                </div>
            </div>
        </div>

    </div>

    <div class="stories-cta">
        <h2>Every Purchase Creates Impact</h2>
        <p>
            When you shop at Zenbaba Market, you support women artisans,
            preserve heritage, and invest in sustainable livelihoods.
        </p>
        <a href="index.php#products">Explore Our Products</a>
    </div>

</div>

