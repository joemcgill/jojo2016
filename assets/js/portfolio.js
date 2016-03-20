/**
 * Portfolio.js
 *
 * Backbone function for powering the portfolio section of the site.
 */
var jojo = jojo || {};

(function ( $, _, Backbone, wp ) {
	'use strict';

	// Default portfolio item view.
	jojo.PortfolioItemView = Backbone.View.extend({

		tagName: 'article',

		className: 'jetpack-portfolio type-jetpack-portfolio status-publish has-post-thumbnail hentry jetpack-portfolio-type-social',

		template: wp.template( 'portfolio-item' ),

		initialize: function() {
			// this.model.on( 'change:active' , function() {
			// 	this.render();
			// } );

		},

		render: function() {
			this.id = 'post-' + this.model.get( 'id' );
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		}

	});

	// Default portfolio view.
	jojo.PortfolioView = Backbone.View.extend({
		el: function() {
			return document.getElementsByClassName( 'portfolio' );
		},

		events: {
			'click .portfolio-category-link' : 'initRouter'
		},

		initialize: function() {
			this.$items = $('.portfolio-list');
			this.listenTo( jojo.portfolio, 'reset', this.addAll );
		},

		initRouter: function( e ) {
			e.preventDefault();

			var pathname = e.target.pathname;

			jojo.router.navigate( pathname, { trigger: true } );
		},

		addAll: function() {
			this.$items.html('');
			jojo.portfolio.each( this.addOne, this );
		},

		addOne: function( item ) {
			var itemView = new jojo.PortfolioItemView( { model: item } );
			this.$items.append( itemView.render().el );
		}
	});


	jojo.PortfolioRouter = Backbone.Router.extend({
		routes: {
			'*notFound' : 'go',
			''          : 'go'
		},

		go: function( pathname ) {
			var url = '/wp-json/wp/v2/jetpack-portfolio';

			if ( -1 !== pathname.indexOf( 'project-type' ) ) {
				var type = pathname.replace( 'project-type/', '' );
				url += '?filter[jetpack-portfolio-type]=' + type;
			}

			jojo.portfolio.url = url;
			jojo.portfolio.fetch( { reset: true } );
		},
	});

	jojo.router = new jojo.PortfolioRouter();

	Backbone.history.start({
		pushState: true,
		silent: true,
	});

	// Backbone model for a portfolio item
	jojo.PortfolioItem = Backbone.Model.extend({
		defaults: {
			id: '',
			title: '',
			link: '',
			category: '',
			thumbnail: {
				alt: '',
				src: '',
				srcset: ''
			}
		}
	});

	// Backbone collection for portfolio items
	jojo.Portfolio = Backbone.Collection.extend({
		model: jojo.PortfolioItem
	});

	jojo.portfolio = new jojo.Portfolio();

	// Kick off the portfolio.
	new jojo.PortfolioView();

} )( jQuery, _, Backbone, wp );
