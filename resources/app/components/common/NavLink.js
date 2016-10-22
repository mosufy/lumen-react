import React from 'react';
import {Link, IndexLink} from 'react-router';

export default class NavLink extends React.Component {
  render() {
    var LinkComponent = this.props.index ? IndexLink : Link;
    return <li><LinkComponent {...this.props} activeClassName="active"/></li>
  }
}
