require 'digest/md5'
module Jekyll

  class Author
    attr_accessor :author, :posts
    def initialize(author, posts)
      self.author = author
      self.posts = posts
    end

    def to_liquid
      hash = Digest::MD5.hexdigest(self.author['mail'])
      text = "<p><div class=\"gravatar\"><img class=\"gravatar\" src=\"http://www.gravatar.com/avatar/#{hash}?s=100\"></div> <b>#{self.author['name']}</b></p>"
      text += "<p>Posts:</p>"
      text += "<ul>"
      self.posts.each do |p|
        text += "<li><a href=\"#{p[:url]}\">#{p[:title]}</a></li>"
      end
      text += "</ul>"
      text
    end
  end

  class AuthorsPageGenerator < Generator
    safe true

    def generate(site)
      authors = {}
      site.posts.docs.each do |post|
        if !authors[post.data["author"]["github"]].nil?
          authors[post.data["author"]["github"]][:posts] << {:url => post.url, :title => post.data["title"]}
        else
          authors[post.data["author"]["github"]] = {:author => post.data["author"], :posts => [{:url => post.url, :title => post.data["title"]}]}
        end
      end
      authors_page = site.pages.detect {|page| page.name == 'authors.html'}
      authors_page.data['authors'] = []
      authors.each do |author, post_data|
        authors_page.data['authors'] << Author.new(post_data[:author], post_data[:posts])
      end
    end
  end

end
