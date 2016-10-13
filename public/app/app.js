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
    var path = this.props.children.props.route.path;
    var header = <Header/>;

    if (path.substring(0, 2) == 'my') {
      header = <HeaderMy/>;
    }

    return (
      <div className="container">
        {header}
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

var HeaderMy = React.createClass({
  render: function () {
    return (
      <div className="header clearfix">
        <nav>
          <ul className="nav nav-pills pull-right">
            <NavLink to="my" index={true}>List</NavLink>
            <NavLink to="my/add">Add</NavLink>
            <NavLink to="logout">Log Out</NavLink>
          </ul>
        </nav>
        <h3 className="text-muted">Welcome, User</h3>
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
        <LoginPanel formType="login"/>
      </div>
    );
  }
});

var Signup = React.createClass({
  render: function () {
    return (
      <div>
        <LoginPanel formType="signup"/>
      </div>
    );
  }
});

var LoginPanel = React.createClass({
  render: function () {
    var formType = this.props.formType;
    var formTitle = 'Sign in to manage your TODOs';
    var alternateText = <Link to="signup" className="text-center new-account">Create an account</Link>;
    var formComponent = (
      <form className="form-signin" onSubmit={this.submit}>
        <input type="email" className="form-control" placeholder="Email" required autoFocus="autoFocus"/>
        <input type="password" className="form-control" placeholder="Password" required/>
        <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    );

    if (formType == 'signup') {
      formTitle = 'Create account and manage your TODOs';
      alternateText = <Link to="login" className="text-center new-account">Have an account? Login</Link>;
      formComponent = (
        <form className="form-signin form-signup" onSubmit={this.submit}>
          <input type="text" className="form-control" placeholder="Name" required autoFocus="autoFocus"/>
          <input type="email" className="form-control" placeholder="Email" required/>
          <input type="password" className="form-control" placeholder="Password" required/>
          <button className="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        </form>
      );
    }

    return (
      <div className="row">
        <div className="col-sm-6 col-md-offset-3">
          <h2 className="text-center login-title">{formTitle}</h2>
          <div className="account-wall">
            {formComponent}
            <Clearfix/>
          </div>
          {alternateText}
          <Clearfix/>
        </div>
      </div>
    );
  },

  submit: function (e) {
    e.preventDefault();
    browserHistory.push('/my');
  }
});

var My = React.createClass({
  render: function () {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>My current TODOs</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
});

var AddTodo = React.createClass({
  render: function () {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>Add New TODO</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
});

var Logout = React.createClass({
  render: function () {
    browserHistory.push('/');
  }
});

var Clearfix = React.createClass({
  render: function() {
    return <span className="clearfix">&nbsp;</span>;
  }
});