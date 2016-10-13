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
        {this.props.children}
        <Footer/>
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
            <NavLink to="login">Login</NavLink>
          </ul>
        </nav>
        <h3 className="text-muted">My TODO</h3>
      </div>
    );
  }
});

var Footer = React.createClass({
  render: function () {
    return (
      <footer className="footer">
        <p>&copy; 2016 Company, Inc.</p>
      </footer>
    );
  }
});

var NavLink = React.createClass({
  render: function () {
    const LinkComponent = this.props.index ? IndexLink : Link;
    return <li><LinkComponent {...this.props} activeClassName="active"/></li>
  }
});

var Hero = React.createClass({
  render: function () {
    return (
      <div className="jumbotron">
        <h1>Welcome</h1>
        <p className="lead">Manage your TODOs today!</p>
        <p>This is a demo/sample for the Lumen-API project. <a href="https://github.com/mosufy/lumen-api" target="_new">https://github.com/mosufy/lumen-api</a>
        </p>
        <p><Link className="btn btn-lg btn-success" to="signup" role="button">Sign up today</Link></p>
      </div>
    );
  }
});

var Home = React.createClass({
  render: function () {
    return (
      <div>
        <Hero/>
        <div className="row marketing">
          <div className="col-lg-12">
            <h4>Subheading</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
          </div>

          <div className="col-lg-12">
            <h4>Subheading</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
          </div>
        </div>
      </div>
    );
  }
});

var About = React.createClass({
  render: function () {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h2>About</h2>
          <p>Mauris sem velit, vehicula eget sodales vitae, rhoncus eget sapien:</p>
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

var Login = React.createClass({
  render: function () {
    return (
      <div>
        <div className="row">
          <div className="col-sm-6 col-md-offset-3">
            <h2 className="text-center login-title">Sign in to manage your TODOs</h2>
            <div className="account-wall">
              <form className="form-signin" onSubmit={this.submit}>
                <input type="text" className="form-control" placeholder="Email" required autoFocus="autoFocus"/>
                <input type="password" className="form-control" placeholder="Password" required/>
                <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                <span className="clearfix">&nbsp;</span>
              </form>
            </div>
            <a href="#" className="text-center new-account">Create an account</a>
            <span className="clearfix">&nbsp;</span>
          </div>
        </div>
      </div>
    );
  },

  submit: function (e) {
    //
  }
});
