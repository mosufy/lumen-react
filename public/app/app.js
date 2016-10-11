/**
 * Main ReactJS app
 *
 * @date 8/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

// Allow to use simple <Router> instead of <ReactRouter.Router>
var {
  Router,
  Route,
  IndexRoute,
  IndexLink,
  Link,
  browserHistory
} = ReactRouter;

var App = React.createClass({
  render: function () {
    return (
      <div className="container">
        <Header/>
      </div>
    )
  }
});

var Header = React.createClass({
  render: function () {
    return (
      <div className="header clearfix">
        <nav>
          <ul className="nav nav-pills pull-right">
            <NavLink to="/" index={true}>Home</NavLink>
            <NavLink to="about">About</NavLink>
            <NavLink to="contact">Contact</NavLink>
          </ul>
        </nav>
        <h3 className="text-muted">Project name</h3>
      </div>
    );
  }
});

var NavLink = React.createClass({
  render: function () {
    const LinkComponent = this.props.index ? IndexLink : Link;
    return <li role="presentation"><LinkComponent {...this.props} activeClassName="active"/></li>
  }
});

var Home = React.createClass({
  render: function () {
    return (
      <div>
        <h2>HELLO</h2>
        <p>Cras facilisis urna ornare ex volutpat, et
          convallis erat elementum. Ut aliquam, ipsum vitae
          gravida suscipit, metus dui bibendum est, eget rhoncus nibh
          metus nec massa. Maecenas hendrerit laoreet augue
          nec molestie. Cum sociis natoque penatibus et magnis
          dis parturient montes, nascetur ridiculus mus.</p>

        <p>Duis a turpis sed lacus dapibus elementum sed eu lectus.</p>
      </div>
    );
  }
});

var About = React.createClass({
  render: function () {
    return (
      <div>
        <h2>STUFF</h2>
        <p>Mauris sem velit, vehicula eget sodales vitae,
          rhoncus eget sapien:</p>
        <ol>
          <li>Nulla pulvinar diam</li>
          <li>Facilisis bibendum</li>
          <li>Vestibulum vulputate</li>
          <li>Eget erat</li>
          <li>Id porttitor</li>
        </ol>
        <div className="content">
          {this.props.children}
        </div>
      </div>
    );
  }
});

var Stuff = React.createClass({
  render: function () {
    return (
      <div>
        <h2>Inner</h2>
        <p>This is inner</p>
      </div>
    );
  }
});

var Contact = React.createClass({
  render: function () {
    return (
      <div>
        <h2>GOT QUESTIONS?</h2>
        <p>The easiest thing to do is post on
          our <a href="http://forum.kirupa.com">forums</a>.
        </p>
      </div>
    );
  }
});
