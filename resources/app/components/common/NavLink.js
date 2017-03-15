import React from 'react';
import {Link, IndexLink} from 'react-router';

const NavLink = (props) => {
  let LinkComponent = props.index ? IndexLink : Link;
  return <li><LinkComponent {...props} activeClassName="active"/></li>
};

export default NavLink;
