import React from 'react';

const SiteLogo = (props) => {
  let logoTitle;

  if (props.pageTemplate == 'public') {
    logoTitle = 'My TODOs';
  } else {
    if (props.user.name == undefined) {
      logoTitle = 'Welcome, User';
    } else {
      logoTitle = 'Welcome, ' + props.user.name;
    }
  }

  return (
    <h3 className="text-muted">{logoTitle}</h3>
  );
};

export default SiteLogo;