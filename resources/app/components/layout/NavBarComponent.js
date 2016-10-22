import React from 'react';
import {browserHistory} from 'react-router';
import NavLink from './../common/NavLink';

export default class NavBarComponent extends React.Component {
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
