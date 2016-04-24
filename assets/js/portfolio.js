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

		className: 'jetpack-portfolio type-jetpack-portfolio status-publish has-post-thumbnail hentry',

		template: wp.template( 'portfolio-item' ),

		initialize: function() {},

		render: function() {
			this.id = 'post-' + this.model.get( 'id' );
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		}

	});

	jojo.PortfolioTileView = Backbone.View.extend({
		className: 'jetpack-portfolio jetpack-porfolio-tile',

		initialize: function() {},

		template: _.template( '<h2 class="jetpack-portfolio-tile-title"><%= name %></h2>' ),

		render: function() {
			this.$el.html( this.template( this.model ) );
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
			this.listenTo( jojo.router, 'route:go', this.updateAll );
		},

		initRouter: function( e ) {
			e.preventDefault();

			var pathname = e.target.pathname;

			jojo.router.navigate( pathname, { trigger: true } );
		},

		updateAll: function() {
			this.$items.html('');

			var type = jojo.router.path;

			_.each( portfolioData.portfolioTypes, function( term ) {
				if ( 'all' === type || type === term.slug ) {
					this.addTile( term );
					this.addGroup( term.slug );
				}
			}, this );
		},

		addAll: function() {
			this.$items.html('');
			jojo.portfolio.each( this.addOne, this );
		},

		addGroup: function( type ) {
			_.each( jojo.portfolio.models, function( item ) {
				if ( -1 !== item.attributes.portfolioType.indexOf( type ) ) {
					this.addOne( item );
				}
			}, this );
		},

		addTile: function( name ) {
			var tileView = new jojo.PortfolioTileView( { model: name } );
			this.$items.append( tileView.render().el );
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

		path: 'all',

		go: function( pathname ) {
			/*
			 * If the previous path wasn't all, we need to fetch a new group
			 * otherwise, we can just hide the ones we don't need.
			 */
			if ( -1 !== pathname.indexOf( 'project-type' ) ) {
				this.path = pathname.replace( 'project-type/', '' );
			} else {
				this.path = 'all';
			}

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

	// var portfolioData = portfolioData || {};

	jojo.portfolio = new jojo.Portfolio( portfolioData.portfolioItems );

	// Kick off the portfolio.
	new jojo.PortfolioView();

} )( jQuery, _, Backbone, wp );
