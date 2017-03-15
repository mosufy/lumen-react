import React from 'react';
import NavBar from './NavBar';
import SiteLogo from './SiteLogo';

const Header = (props) => {
  return (
    <div className="header clearfix">
      <NavBar pageTemplate={props.pageTemplate} logoutLink={props.logoutLink}/>
      <SiteLogo pageTemplate={props.pageTemplate} user={props.user}/>
    </div>
  );
};

export default Header;