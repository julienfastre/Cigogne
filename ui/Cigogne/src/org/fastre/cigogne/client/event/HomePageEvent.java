package org.fastre.cigogne.client.event;

import com.google.gwt.event.shared.GwtEvent;

public class HomePageEvent extends GwtEvent<HomePageEventHandler> {
	public static Type<HomePageEventHandler> TYPE = new Type<HomePageEventHandler>();

	public Type<HomePageEventHandler> getAssociatedType() {
		return TYPE;
	}

	protected void dispatch(HomePageEventHandler handler) {
		handler.onHomePage(this);
		
	}

}
