/**
 * MyTodoVisibilityFilterLink
 *
 * @date 24/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';

const MyTodoVisibilityFilterLink = (props) => {
  let visibilityFilter = props.visibilityFilter;
  let currentFilter = props.filter;
  let btnStyle = 'btn btn-default btn-sm';
  let btnClick = props.setVisibilityFilter;

  if (currentFilter == visibilityFilter) {
    btnClick = '';
    if (currentFilter == 'SHOW_ALL') {
      btnStyle = 'btn btn-primary btn-sm';
    } else if (currentFilter == 'SHOW_ACTIVE') {
      btnStyle = 'btn btn-danger btn-sm';
    } else if (currentFilter == 'SHOW_COMPLETED') {
      btnStyle = 'btn btn-success btn-sm';
    }
  }

  return (
    <button id={currentFilter} type="button" className={btnStyle} onClick={btnClick}>{props.children}</button>
  );
};

export default MyTodoVisibilityFilterLink;