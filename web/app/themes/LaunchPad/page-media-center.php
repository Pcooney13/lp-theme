<?php 
/**
 * The template for displaying the Media Center page.
 *
 */
get_header(); 

$args = array(
    "posts_per_page" => -1, 
    "post_type" => ['news', 'press'],
    'meta_key' => 'date',
    'orderby' => 'meta_value',
    'order' => 'DESC',
);
// the query
$news_query = new WP_Query( $args );

$args = array(
"posts_per_page" => -1, 
"post_type" => 'press');
// the query
$press_query = new WP_Query( $args );

?>

<style>
	[x-cloak] { 
        display: none !important; 
    }
	.sc-links-blue a:not(.btn) {
		color: #2a8adf;
		text-decoration: underline;
		font-weight: normal;
		transition: all .3s ease;
	}
	.sc-links-blue a:not(.btn):hover {
		color: #5dc6c2;
	}
	.sc-content ul {
		list-style: disc;
		padding-left: 1.5rem;
	}
	.sc-content ul * {
		margin-top:0.5rem;
	}
    button:disabled {
        pointer-events: none;
        opacity: 0.5;
    }
</style>

<section class="bg-white border-b border-slate-200 px-0 md:px-8 w-full pt-0 md:pt-12 pb-12">
    <div class="max-w-screen-2xl mx-auto flex gap-8 items-center justify-center flex-col md:flex-row">
        <div class="space-y-4 order-2 md:order-1 flex-1 font-mont font-normal px-4 leading-8 text-lg sc-content sc-links-blue">
            <p class="font-mont font-bold text-2xl md:text-3xl">Media Center</p>
            <p>The Schwartz Center's Media Center offers a variety news, videos and other resources for our supporters and journalists.</p>
        </div>
        <img class="aspect-video md:w-1/2 object-cover order-1 md:order-2" src="https://tsc.launchpaddev.com/wp-content/uploads/2019/05/media-center.jpg">
    </div>
</section>

<?php include(locate_template('templates/schwartz-custom/breadcrumbs.php', false, false)); ?>


    <div>
        <?php if ($news_query->have_posts()) : ?>
            <section 
                class="bg-slate-50 py-16"
                x-data="{
                    perPage: 9,
                    currentPage: 1,
                    filter: 'all',
                    setFilter(type) {
                        this.filter = type;
                        this.currentPage = 1;
                    },
                    getFilteredPosts() {
                        return Array.from(this.$refs.posts.children).filter((post) => {
                            return this.filter === 'all' || post.dataset.type === this.filter;
                        });
                    },
                    updateVisibility() {
                        const posts = Array.from(this.$refs.posts.children);
                        const filtered = this.getFilteredPosts();

                        posts.forEach((post) => {
                            post.style.display = 'none';
                        });

                        filtered.forEach((post, index) => {
                            post.style.display =
                                index >= (this.currentPage - 1) * this.perPage &&
                                index < this.currentPage * this.perPage
                                    ? 'flex'
                                    : 'none';
                        });
                    },
                    get totalPages() {
                        return Math.ceil(this.getFilteredPosts().length / this.perPage) || 1;
                    }
                }"
                x-init="updateVisibility()"
                x-effect="updateVisibility()"
            >
                <div class="max-w-screen-md mx-auto px-4 space-y-8">
                    <h2 class="font-mont font-bold text-xl md:text-2xl text-center">Press Releases & News Articles</h2>

                    <div class="flex justify-center items-center gap-3 flex-wrap" role="group" aria-label="Filter media items">
                        <button
                            type="button"
                            @click="setFilter('all')"
                            :class="filter === 'all' ? 'bg-sc-teal text-white' : 'bg-transparent text-sc-teal hover:bg-sc-teal hover:text-white'"
                            class="text-sm px-8 py-1.5 transition border-2 border-sc-teal font-mont font-medium uppercase"
                        >
                            All
                        </button>
                        <button
                            type="button"
                            @click="setFilter('news')"
                            :class="filter === 'news' ? 'bg-sc-teal text-white' : 'bg-transparent text-sc-teal hover:bg-sc-teal hover:text-white'"
                            class="text-sm px-8 py-1.5 transition border-2 border-sc-teal font-mont font-medium uppercase"
                        >
                            News Articles
                        </button>
                        <button
                            type="button"
                            @click="setFilter('press')"
                            :class="filter === 'press' ? 'bg-sc-teal text-white' : 'bg-transparent text-sc-teal hover:bg-sc-teal hover:text-white'"
                            class="text-sm px-8 py-1.5 transition border-2 border-sc-teal font-mont font-medium uppercase"
                        >
                            Press Releases
                        </button>
                    </div>

                    <div x-ref="posts" class="space-y-6">
                        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                            <?php $post_type = get_post_type(); ?>
                            <div class="flex items-center gap-2" data-type="<?php echo esc_attr( $post_type ); ?>">
                                <?php if ($post_type === 'press') : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="h-16 w-16 text-sc-teal">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                                </svg>
                                <?php elseif ($post_type === 'news') : ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="h-16 w-16 text-sc-teal">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                    </svg>
                                <?php endif; ?>
                                <div class="flex-1">
                                    <div class="flex gap-4">
                                        <p class="font-mont text-sm text-slate-500"><?php echo get_field('date'); ?></p>
                                        <?php if (get_field('source')) : ?>
                                            <p class="font-mont text-sm text-slate-500"><?php echo get_field('source'); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="font-mont font-normal text-lg sc-content sc-links-blue">
                                        <a 
                                            href="<?php 
                                                if (get_field('format') == 'link') echo get_field('link');
                                                if (get_field('format') == 'file') echo get_field('file'); 
                                            ?>" 
                                            title="<?php the_title(); ?>" 
                                            target="_blank">
                                            <?php the_title(); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>

                    <!-- Pagination controls -->
                    <div class="flex justify-center items-center gap-8 mt-8">
                        <button 
                            @click="if (currentPage > 1) currentPage--"
                            :disabled="currentPage === 1"
                            class="text-sm px-8 py-1.5 transition border-2 border-sc-teal font-mont font-medium bg-sc-teal text-white uppercase hover:bg-transparent hover:text-sc-teal"
                        >
                            Prev
                        </button>
                        <span class="font-mont text-sm" x-text="`Page ${currentPage} of ${totalPages}`"></span>
                        <button 
                            @click="if (currentPage < totalPages) currentPage++"
                            :disabled="currentPage === totalPages"
                            class="text-sm px-8 py-1.5 transition border-2 border-sc-teal font-mont font-medium bg-sc-teal text-white uppercase hover:bg-transparent hover:text-sc-teal"
                        >
                            Next
                        </button>
                    </div>
                </div>

                <div class="max-w-screen-md mx-auto px-4 pt-16 space-y-8 sc-content text-center sc-links-blue">
                    <h2 class="font-mont font-bold text-xl md:text-2xl">Videos</h2>
                    <p class="space-y-4 order-2 md:order-1 flex-1 font-mont font-normal px-4 leading-8 text-lg">The Schwartz Center video gallery provides a close-up view of the events, programs and people that are central to our work.</p>
                    <a href="/resources/videos/" class="btn">View Videos</a>
                </div>
            </section>
        <?php endif; ?>
    </div>


    

<?php get_footer(); ?>
