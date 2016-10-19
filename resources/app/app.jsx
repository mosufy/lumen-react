/**
 * Main ReactJS app
 *
 * @date 8/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import ReactDOM from 'react-dom';
import {Router, Route, IndexRoute, Link, IndexLink, browserHistory} from 'react-router';

class NavLink extends React.Component {
  render() {
    var LinkComponent = this.props.index ? IndexLink : Link;
    return <li><LinkComponent {...this.props} activeClassName="active"/></li>
  }
}

class App extends React.Component {
  render() {
    var path = this.props.children.props.route.path;
    var pageTemplate = 'public';

    if (path && path.substring(0, 2) == 'my') {
      pageTemplate = 'my';
    }

    return (
      <div className="container">
        <Header pageTemplate={pageTemplate}/>
        {this.props.children}
        <Footer/>
      </div>
    )
  }
}

class Header extends React.Component {
  render() {
    return (
      <div className="header clearfix">
        <NavBarComponent pageTemplate={this.props.pageTemplate}/>
        <SiteLogoComponent pageTemplate={this.props.pageTemplate}/>
      </div>
    );
  }
}

class SiteLogoComponent extends React.Component {
  render() {
    var logoTitle;

    if (this.props.pageTemplate == 'public') {
      logoTitle = 'My TODOs';
    } else {
      logoTitle = 'Welcome, User';
    }

    return (
      <h3 className="text-muted">{logoTitle}</h3>
    );
  }
}

class NavBarComponent extends React.Component {
  static defaultProps = {
    navIndex: true
  };

  static propTypes = {
    navIndex: React.PropTypes.bool
  };

  render() {
    var navlinks;

    if (this.props.pageTemplate == 'public') {
      navlinks = (
        <ul className="nav nav-pills pull-right">
          <NavLink to="/" {...this.props.navIndex}>Home</NavLink>
          <NavLink to="about">About</NavLink>
          <NavLink to="contact">Contact</NavLink>
          <NavLink to="login">Login</NavLink>
        </ul>
      );
    } else {
      navlinks = (
        <ul className="nav nav-pills pull-right">
          <NavLink to="my" {...this.props.navIndex}>List</NavLink>
          <NavLink to="my/add">Add</NavLink>
          <li onClick={this.logout}><a href="/">Log Out</a></li>
        </ul>
      );
    }

    return (
      <nav>
        {navlinks}
      </nav>
    );
  }

  logout(e) {
    e.preventDefault();
    browserHistory.push('/');
  }
}

class Footer extends React.Component {
  render() {
    return (
      <footer className="footer">
        <p>&copy; 2016 Company, Inc.</p>
      </footer>
    );
  }
}

class Hero extends React.Component {
  render() {
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
}

class Home extends React.Component {
  render() {
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
}

class About extends React.Component {
  render() {
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
}

class Stuff extends React.Component {
  render() {
    return (
      <div>
        <h2>Inner</h2>
        <p>This is inner</p>
      </div>
    );
  }
}

class Contact extends React.Component {
  render() {
    return (
      <div>
        <h2>GOT QUESTIONS?</h2>
        <p>The easiest thing to do is post on our <a href="http://forum.kirupa.com">forums</a>.
        </p>
      </div>
    );
  }
}

class Login extends React.Component {
  render() {
    return (
      <div>
        <LoginPanel formType="login"/>
      </div>
    );
  }
}

class Signup extends React.Component {
  render() {
    return (
      <div>
        <LoginPanel formType="signup"/>
      </div>
    );
  }
}

class LoginPanel extends React.Component {
  render() {
    var formType = this.props.formType;
    var formTitle = 'Sign in to manage your TODOs';
    var alternateText = <Link to="signup" className="text-center new-account">Create an account</Link>;
    var formComponent = (
      <form className="form-signin" onSubmit={this.submitForm}>
        <input type="email" className="form-control" placeholder="Email" required autoFocus="autoFocus"/>
        <input type="password" className="form-control" placeholder="Password" required/>
        <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    );

    if (formType == 'signup') {
      formTitle = 'Create account and manage your TODOs';
      alternateText = <Link to="login" className="text-center new-account">Have an account? Login</Link>;
      formComponent = (
        <form className="form-signin form-signup" onSubmit={this.submitForm}>
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
  }

  submitForm(e) {
    e.preventDefault();
    browserHistory.push('/my');
  }
}

class My extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>My current TODOs</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
}

class AddTodo extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>Add New TODOs</h4>
          <Clearfix/>
        </div>
      </div>
    );
  }
}

class Clearfix extends React.Component {
  render() {
    return <span className="clearfix">&nbsp;</span>;
  }
}

ReactDOM.render(
  <Router history={browserHistory}>
    <Route path="/" component={App}>
      <IndexRoute component={Home}/>
      <Route path="about" component={About}>
        <Route path="stuff" component={Stuff}/>
      </Route>
      <Route path="contact" component={Contact}/>
      <Route path="login" component={Login}/>
      <Route path="signup" component={Signup}/>
      <Route path="my" component={My}/>
      <Route path="my/add" component={AddTodo}/>
    </Route>
  </Router>,
  document.getElementById('container')
);
